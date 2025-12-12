<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;

class KosController extends Controller
{
    public function index()
    {
        return Kos::with(['images', 'facilities', 'reviews'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'price_per_month' => 'required|numeric',
            'gender' => 'required'
        ]);

        return Kos::create($request->all());
    }

    public function show($id)
    {
        return Kos::with(['images', 'facilities', 'reviews'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kos = Kos::findOrFail($id);
        $kos->update($request->all());
        return $kos;
    }

    public function destroy($id)
    {
        Kos::destroy($id);
        return ['message' => 'Kos deleted'];
    }
}
