<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\Peminjam;
use Illuminate\Http\Request;

class PeminjamanBukuController extends Controller
{
    /**
     * Menampilkan semua data peminjaman.
     */
    public function index()
    {
        $peminjams = Peminjam::with(['anggota', 'buku'])->orderBy('created_at', 'desc')->get();
        return view('pustakawan.peminjaman.index', compact('peminjams'));
    }

    /**
     * Update status peminjaman menjadi "dikembalikan".
     */
    public function update(Request $request, $id)
    {
        $peminjam = Peminjam::findOrFail($id);
        $peminjam->status_pinjam = 'dikembalikan';
        $peminjam->save();

        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman diperbarui.');
    }

    /**
     * Hapus data peminjaman.
     */
    public function destroy($id)
    {
        $peminjam = Peminjam::findOrFail($id);
        $peminjam->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
