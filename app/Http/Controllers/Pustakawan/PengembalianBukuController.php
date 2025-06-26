<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\Peminjam;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianBukuController extends Controller
{
    // Tampilkan daftar peminjaman dengan status 'done'
    public function index()
    {
        $peminjams = Peminjam::with(['anggota', 'buku', 'pengembalian'])
            ->where('status_pinjam', 'done')
            ->latest()
            ->get();

        return view('pustakawan.pengembalian.index', compact('peminjams'));
    }

    // Tandai selesai: menyimpan ke tabel pengembalian
    public function update(Request $request, $id_pinjam)
    {
        $peminjam = Peminjam::with('anggota', 'buku')->findOrFail($id_pinjam);

        $tgl_kembali = $peminjam->updated_at;
        $batas_kembali = $peminjam->batas_kembali;

        $denda = 0;
        $status_kembali = 'selesai';

        if ($tgl_kembali->gt($batas_kembali)) {
            $selisih = $tgl_kembali->diffInDays($batas_kembali);
            $denda = $selisih * 1000;
            $status_kembali = 'terlambat';
        }

        // Cegah duplikasi
        Pengembalian::updateOrCreate(
            ['id_pinjam' => $id_pinjam],
            [
                'tgl_kembali' => $tgl_kembali,
                'denda' => $denda,
                'status_kembali' => $status_kembali
            ]
        );

        return redirect()->back()->with('success', 'Pengembalian berhasil ditandai.');
    }
}
