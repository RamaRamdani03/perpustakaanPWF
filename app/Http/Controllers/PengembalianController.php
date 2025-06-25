<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function store(Request $request)
    {
        $v = $request->validate(['id_pinjam' => 'required|exists:peminjams,id_pinjam']);
        $pinjam = Peminjam::findOrFail($v['id_pinjam']);

        $tglkembali = now();
        $denda = $tglkembali->gt($pinjam->batas_kembali)
            ? $tglkembali->diffInDays($pinjam->batas_kembali) * 1000
            : 0;

        $peng = Pengembalian::create([
            'id_pinjam' => $v['id_pinjam'],
            'tgl_kembali' => $tglkembali,
            'denda' => $denda,
            'status_kembali' => $denda > 0 ? 'terlambat' : 'selesai'
        ]);

        $pinjam->update(['status_pinjam' => 'dikembalikan']);
        return $peng;
    }

    public function index()
    {
        return Pengembalian::with(['peminjam.buku', 'peminjam.anggota'])->get();
    }
}
