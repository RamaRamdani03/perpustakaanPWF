<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function index()
    {
        return Peminjam::with(['buku', 'anggota'])->get();
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'id_anggota' => 'required|exists:anggotas,id_anggota',
            'id_buku' => 'required|exists:bukus,id_buku',
        ]);

        // Set tanggal pinjam & batas
        $v['tgl_pinjam'] = now();
        $v['batas_kembali'] = now()->addDays(7);
        $v['status_pinjam'] = 'dipinjam';

        return Peminjam::create($v);
    }

    public function show($id)
    {
        return Peminjam::with(['buku', 'anggota', 'pengembalian'])->findOrFail($id);
    }

    public function destroy($id)
    {
        Peminjam::destroy($id);
        return response()->json(['message' => 'Dihapus']);
    }
}
