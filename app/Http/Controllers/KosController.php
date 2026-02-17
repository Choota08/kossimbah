<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;

class KosController extends Controller
{
    public function index()
    {
        $kos = Kos::with(['images', 'facilities'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $kos
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'address' => 'required|string',
            'price_per_month' => 'required|numeric',
            'gender' => 'required|string'
        ]);

        $kos = Kos::create($validated);

        return response()->json([
            'status' => true,
            'data' => $kos
        ], 201);
    }

    public function show($id)
    {
        $kos = Kos::with(['images', 'facilities', 'reviews.user'])
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $kos
        ]);
    }

    public function update(Request $request, $id)
    {
        $kos = Kos::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'price_per_month' => 'sometimes|numeric',
            'gender' => 'sometimes|string'
        ]);

        $kos->update($validated);

        return response()->json([
            'status' => true,
            'data' => $kos
        ]);
    }

    public function destroy($id)
    {
        Kos::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Kos deleted'
        ]);
    }
}
