<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjam')->latest()->get();
        return view('pustakawan.pengembalian.index', compact('pengembalians'));
    }

    public function create($id_pinjam)
    {
        $peminjam = Peminjam::with('anggota', 'buku')->findOrFail($id_pinjam);
        return view('pustakawan.pengembalian.create', compact('peminjam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pinjam'     => 'required|exists:peminjams,id_pinjam',
            'tgl_kembali'   => 'required|date',
        ]);

        $peminjam = Peminjam::findOrFail($request->id_pinjam);

        // Hitung denda (misalnya: 1000 per hari keterlambatan)
        $batasPinjam = Carbon::parse($peminjam->tgl_pinjam)->addDays(7); // asumsi 7 hari batas peminjaman
        $tglKembali = Carbon::parse($request->tgl_kembali);

        $selisihHari = $tglKembali->diffInDays($batasPinjam, false); // nilai bisa negatif

        $denda = 0;
        $status = 'selesai';
        if ($selisihHari > 0) {
            $denda = $selisihHari * 1000; // contoh: denda 1000 per hari
            $status = 'terlambat';
        }

        // Simpan pengembalian
        Pengembalian::create([
            'id_pinjam' => $peminjam->id_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'denda' => $denda,
            'status_kembali' => $status,
        ]);

        // Update status peminjam
        $peminjam->status_pinjam = 'dikembalikan';
        $peminjam->save();

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian berhasil diproses.');
    }
}
