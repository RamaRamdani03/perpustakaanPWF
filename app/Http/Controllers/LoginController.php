<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function username()
    {
        return 'name'; 
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Blade form
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role->name;

            return match ($role) {
                'admin' => redirect('/admin/dashboard'),
                'pustakawan' => redirect('/pustakawan/dashboard'),
                'anggota' => redirect('/anggota/dashboard'),
                default => abort(403),
            };
        }

        return back()->withErrors(['name' => 'Nama atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
