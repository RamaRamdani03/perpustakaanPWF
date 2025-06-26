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
    return redirect()->route('login');
});

// Admin routes
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('pustakawan', PustakawanController::class);
    Route::resource('kategori', KategoriController::class);
});

// Pustakawan routes
Route::prefix('pustakawan')->middleware('auth:pustakawan')->group(function () {
    Route::get('/dashboard', [PustakawanDashboardController::class, 'index'])->name('pustakawan.dashboard');

    Route::resource('buku', BukuController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('peminjaman', PeminjamanBukuController::class);
});

// Anggota routes
Route::prefix('anggota')->middleware('auth:anggota')->group(function () {
    Route::get('/dashboard', function () {
        return view('anggota.dashboard');
    });
});
