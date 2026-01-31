<?php

namespace App\Http\Controllers;

use App\Models\KosFacility;
use Illuminate\Http\Request;

class KosFacilityController extends Controller
{
    // CREATE
    public function store(Request $request)
    {
        return KosFacility::create([
            'kos_id' => $request->kos_id,
            'facility' => $request->facility
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        KosFacility::findOrFail($id)->delete();
        return response()->json(['message' => 'Facility deleted']);
    }
}


