<?php
namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Peminjam;
use App\Models\Buku;

class PustakawanDashboardController extends Controller
{
    public function index()
    {
        $jumlahBuku = Buku::count();
        $jumlahAnggota = Anggota::count();
        $jumlahPeminjam = Peminjam::count();

        return view('pustakawan.dashboard', compact('jumlahBuku', 'jumlahAnggota', 'jumlahPeminjam'));
    }
}
