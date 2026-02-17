<?php

namespace App\Http\Controllers;

use App\Models\KosFacility;
use App\Models\Kos;
use Illuminate\Http\Request;

class KosFacilityController extends Controller
{
    // CREATE facility
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'facility' => 'required|string|max:255',
        ]);

        $facility = KosFacility::create($validated);

        return response()->json([
            'status' => true,
            'data' => $facility
        ], 201);
    }

    // DELETE facility by facility_id
    public function destroy($id)
    {
        $facility = KosFacility::findOrFail($id);
        $facility->delete();

        return response()->json([
            'status' => true,
            'message' => 'Facility deleted'
        ]);
    }

    // 🔥 DELETE ALL facilities by kos_id
    public function destroyByKos($kosId)
    {
        KosFacility::where('kos_id', $kosId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'All facilities deleted'
        ]);
    }
}
