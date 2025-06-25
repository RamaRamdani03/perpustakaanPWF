<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PustakawanAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('usr_pustaka', 'password');

        if (!$token = Auth::guard('pustakawan')->attempt([
            'usr_pustaka' => $credentials['usr_pustaka'],
            'pw_pustaka' => $credentials['password'],
        ])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('pustakawan')->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(Auth::guard('pustakawan')->user());
    }

    public function logout()
    {
        Auth::guard('pustakawan')->logout();
        return response()->json(['message' => 'Logged out']);
    }
}
