<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Form login
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Login sebagai admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }

        // Login sebagai pustakawan
        if (Auth::guard('pustakawan')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/pustakawan/dashboard');
        }

        // Login sebagai anggota
        if (Auth::guard('anggota')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/anggota/dashboard');
        }

        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        // Logout dari semua guard yang mungkin aktif
        foreach (['admin', 'pustakawan', 'anggota'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
