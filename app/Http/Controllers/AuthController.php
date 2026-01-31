<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * LOGIN (SESSION + TOKEN)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // ✅ Aman untuk WEB saja
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        $user = Auth::user();

        // Token untuk API / Postman / Frontend
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user'    => $user,
            'token'   => $token,
            'role'    => $user->role
        ], 200);
    }

    /**
     * LOGOUT (SESSION + TOKEN)
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        // Hapus token (API)
        if ($user) {
            $user->tokens()->delete();
        }

        // Logout session (WEB)
        Auth::logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
