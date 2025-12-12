<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET ALL
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // CREATE USER
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone'    => 'nullable',
            'role'     => 'required',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => $request->role,
        ]);

        return response()->json($user, 201);
    }

    // GET ONE USER
    public function show($id)
    {
        return response()->json(User::findOrFail($id), 200);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'phone'    => $request->phone ?? $user->phone,
            'role'     => $request->role ?? $user->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json($user, 200);
    }

    // DELETE USER
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted'], 200);
    }
}
