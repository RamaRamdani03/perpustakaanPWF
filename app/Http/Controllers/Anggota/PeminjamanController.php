<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjam;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $books = Buku::all();
        return view('anggota.dashboard', compact('books'));

        if ($request->hasFile('cover')) {
            $data['cover'] = file_get_contents($request->file('cover')->getRealPath());
        }
    }

    public function riwayat()
    {
        $anggota = Auth::guard('anggota')->user();

        $peminjamans = Peminjam::with('buku')
            ->where('id_anggota', $anggota->id_anggota)
            ->whereIn('status_pinjam', ['unaccepted', 'accepted']) 
            ->orderByDesc('tgl_pinjam')
            ->get();

        return view('anggota.pinjam.index', compact('peminjamans'));
    }

    // public function create()
    // {
    //     $books = Buku::all();
    //     return view('anggota.pinjam.form', compact('books'));
    // }

    public function create()
    {
        $anggota = Auth::guard('anggota')->user();

        // Ambil ID buku yang masih dipinjam oleh anggota (status belum selesai)
        $bukuYangSedangDipinjam = Peminjam::where('id_anggota', $anggota->id_anggota)
            ->whereIn('status_pinjam', ['unaccepted', 'accepted'])
            ->pluck('id_buku');

        // Ambil semua buku kecuali yang sedang dipinjam anggota
        $books = Buku::whereNotIn('id_buku', $bukuYangSedangDipinjam)->get();

        return view('anggota.pinjam.form', compact('books'));
    }


    // public function store($id_buku)
    // {
    //     $anggota = Auth::guard('anggota')->user();

    //     $sudahPinjam = Peminjam::where('id_anggota', $anggota->id_anggota)
    //         ->where('id_buku', $id_buku)
    //         ->whereIn('status_pinjam', ['unaccepted', 'accepted']) // ✅ Hindari pinjam berulang
    //         ->exists();

    //     if ($sudahPinjam) {
    //         return redirect()->back()->with('error', 'Kamu sudah meminjam buku ini.');
    //     }

    //     Peminjam::create([
    //         'id_anggota' => $anggota->id_anggota,
    //         'id_buku' => $id_buku,
    //         'tgl_pinjam' => now(),
    //         'batas_kembali' => Carbon::now()->addDays(7),
    //         'status_pinjam' => 'unaccepted', // ✅ sesuai enum
    //     ]);

    //     return redirect()->route('anggota.pinjam.riwayat')->with('success', 'Berhasil meminjam buku.');
    // }

    public function store($id_buku)
{
    $anggota = Auth::guard('anggota')->user();

    $sudahPinjam = Peminjam::where('id_anggota', $anggota->id_anggota)
        ->where('id_buku', $id_buku)
        ->whereIn('status_pinjam', ['unaccepted', 'accepted']) 
        ->exists();

    if ($sudahPinjam) {
        return redirect()->back()->with('error', 'Kamu sudah meminjam buku ini.');
    }

    Peminjam::create([
        'id_anggota' => $anggota->id_anggota,
        'id_buku' => $id_buku,
        'tgl_pinjam' => now(),
        'batas_kembali' => Carbon::now()->addDays(3),
        'status_pinjam' => 'unaccepted', // akan diverifikasi oleh pustakawan
    ]);

    return redirect()->route('anggota.pinjam.riwayat')->with('success', 'Permintaan peminjaman dikirim. Menunggu konfirmasi.');
}


    public function show($id)
    {
        $peminjaman = Peminjam::with('buku')->findOrFail($id);
        $anggota = Auth::guard('anggota')->user();

        if ($peminjaman->id_anggota !== $anggota->id_anggota) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('anggota.pinjam.show', compact('peminjaman'));
    }

    // public function kembalikan($id_pinjam)
    // {
    //     $peminjaman = Peminjam::findOrFail($id_pinjam);

    //     if ($peminjaman->status_pinjam === 'unaccepted') {
    //         return redirect()->back()->with('info', 'Buku ini sudah dikembalikan sebelumnya.');
    //     }

    //     $peminjaman->update([
    //         'status_pinjam' => 'unaccepted', // ✅ Anggap accepted = selesai
    //     ]);

    //     return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    // }

    public function kembalikan($id_pinjam)
{
    $peminjaman = Peminjam::findOrFail($id_pinjam);
    $anggota = Auth::guard('anggota')->user();

    // Validasi hanya milik anggota yang login
    if ($peminjaman->id_anggota !== $anggota->id_anggota) {
        abort(403, 'Akses tidak diizinkan.');
    }

    if ($peminjaman->status_pinjam !== 'accepted') {
        return redirect()->back()->with('info', 'Peminjaman belum dikonfirmasi atau sudah dikembalikan.');
    }

    // TANDAKAN bahwa anggota ingin mengembalikan, misalnya ganti ke 'return_requested'
    $peminjaman->update([
        'status_pinjam' => 'done', // nanti pustakawan yang set jadi 'returned'
    ]);

    return redirect()->back()->with('success', 'Permintaan pengembalian dikirim. Menunggu konfirmasi.');
}

public function showimage($id)
    {
        $buku = Buku::findOrFail($id);

        if (!$buku->cover) {
            abort(404, 'Cover not found');
        }

        return response($buku->cover)
            ->header('Content-Type', 'image/jpeg/jpg'); // Sesuaikan jika image/png
    }

}
