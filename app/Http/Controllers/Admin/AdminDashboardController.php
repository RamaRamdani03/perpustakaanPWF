<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use App\Models\Pustakawan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahKategori = KategoriBuku::count();
        $jumlahPustakawan = Pustakawan::count();

        return view('admin.dashboard', compact('jumlahKategori', 'jumlahPustakawan'));
    }
}
