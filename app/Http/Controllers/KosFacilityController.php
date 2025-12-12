<?php

namespace App\Http\Controllers;

use App\Models\KosFacility;
use Illuminate\Http\Request;

class KosFacilityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kos_id' => 'required',
            'facility' => 'required'
        ]);

        return KosFacility::create($request->all());
    }

    public function destroy($id)
    {
        KosFacility::destroy($id);
        return ['message' => 'Facility deleted'];
    }
}

