<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;  
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Pustakawan\PustakawanDashboardController;
use App\Http\Controllers\Admin\PustakawanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Pustakawan\BukuController;
use App\Http\Controllers\Pustakawan\AnggotaController;
use App\Http\Controllers\Pustakawan\PeminjamanBukuController;
use App\Http\Controllers\Pustakawan\KategoriBukuController;
use App\Http\Controllers\Pustakawan\PengembalianBukuController;
use App\Http\Controllers\Anggota\PeminjamanController;

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman root: redirect sesuai guard
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect('/admin/dashboard');
    } elseif (Auth::guard('pustakawan')->check()) {
        return redirect('/pustakawan/dashboard');
    } elseif (Auth::guard('anggota')->check()) {
        return redirect('/anggota/dashboard');
    }
    // Tampilkan landing page jika belum login
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Tampilkan semua pustakawan
    Route::get('/pustakawan', [PustakawanController::class, 'index'])->name('pustakawan.index');
    Route::get('/pustakawan/create', [PustakawanController::class, 'create'])->name('pustakawan.create');
    Route::post('/pustakawan', [PustakawanController::class, 'store'])->name('pustakawan.store');
    Route::get('/pustakawan/{id}/edit', [PustakawanController::class, 'edit'])->name('pustakawan.edit');
    Route::put('/pustakawan/{id}', [PustakawanController::class, 'update'])->name('pustakawan.update');
    Route::delete('/pustakawan/{id}', [PustakawanController::class, 'destroy'])->name('pustakawan.destroy');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

});

// Pustakawan routes
Route::prefix('pustakawan')->middleware('auth:pustakawan')->group(function () {
    Route::get('/dashboard', [PustakawanDashboardController::class, 'index'])->name('pustakawan.dashboard');

    // Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanBukuController::class, 'index'])->name('peminjaman.index');
    Route::put('/peminjaman/{id}', [PeminjamanBukuController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{id}', [PeminjamanBukuController::class, 'destroy'])->name('peminjaman.destroy');

    Route::get('/pengembalian', [PengembalianBukuController::class, 'index'])->name('pengembalian.index');
    Route::put('/pengembalian/{id}', [PengembalianBukuController::class, 'update'])->name('pengembalian.update');

    Route::get('/kategori', [KategoriBukuController::class, 'index'])->name('pustakawan.kategori.index');
    Route::get('/kategori/create', [KategoriBukuController::class, 'create'])->name('pustakawan.kategori.create');
    Route::post('/kategori', [KategoriBukuController::class, 'store'])->name('pustakawan.kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriBukuController::class, 'edit'])->name('pustakawan.kategori.edit');
    Route::put('/kategori/{id}', [KategoriBukuController::class, 'update'])->name('pustakawan.kategori.update');
    Route::delete('/kategori/{id}', [KategoriBukuController::class, 'destroy'])->name('pustakawan.kategori.destroy');
});

Route::get('/cover/{id}', [PeminjamanController::class, 'showimage']);

Route::middleware(['auth:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [PeminjamanController::class, 'index'])->name('dashboard');
    Route::get('/pinjam', [PeminjamanController::class, 'riwayat'])->name('pinjam.riwayat');
    Route::get('/pinjam/form', [PeminjamanController::class, 'create'])->name('pinjam.form');
    Route::post('/pinjam/{id_buku}', [PeminjamanController::class, 'store'])->name('pinjam.store');
    Route::get('/pinjam/{id}', [PeminjamanController::class, 'show'])->name('pinjam.show');
    Route::post('/pinjam/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('pinjam.kembalikan');
});


