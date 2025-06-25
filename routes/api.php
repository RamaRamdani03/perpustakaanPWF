<?php

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');

// Admin-only
Route::middleware(['auth:api', 'jwt.role:admin'])->group(function () {
    Route::get('/admin/dashboard', fn() => response()->json(['message' => 'Halo Admin']));
});

// Pustakawan-only
Route::middleware(['auth:api', 'jwt.role:pustakawan'])->group(function () {
    Route::get('/pustakawan/dashboard', fn() => response()->json(['message' => 'Halo Pustakawan']));
});

// Anggota-only
Route::middleware(['auth:api', 'jwt.role:anggota'])->group(function () {
    Route::get('/anggota/dashboard', fn() => response()->json(['message' => 'Halo Anggota']));
});
