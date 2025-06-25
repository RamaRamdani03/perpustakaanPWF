<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman root redirect berdasarkan role
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/' . auth()->user()->role->name . '/dashboard');
    }
    return redirect()->route('login');
});

// Dashboard masing-masing role
Route::middleware(['auth', 'role:admin'])
    ->get('/admin/dashboard', fn() => view('admin.dashboard'));

Route::middleware(['auth', 'role:pustakawan'])
    ->get('/pustakawan/dashboard', fn() => view('pustakawan.dashboard'));

Route::middleware(['auth', 'role:anggota'])
    ->get('/anggota/dashboard', fn() => view('anggota.dashboard'));
