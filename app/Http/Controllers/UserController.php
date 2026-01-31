<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ADMIN - GET ALL USERS
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * ADMIN - GET USER BY ID
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    /**
     * USER - GET PROFILE SENDIRI (LOGIN)
     */
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], 200);
    }

    /**
     * USER - UPDATE PROFILE (LOGIN)
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user'    => $user
        ], 200);
    }

    /**
     * USER - CHANGE PASSWORD (LOGIN)
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        // cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Password lama salah'
            ], 422);
        }

        // update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password berhasil diperbarui'
        ], 200);
    }

    /**
     * REGISTER (PUBLIC)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'role'     => 'user',
        ]);

        return response()->json([
            'message' => 'Register berhasil',
            'user'    => $user
        ], 201);
    }
}
