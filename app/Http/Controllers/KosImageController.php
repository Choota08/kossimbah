<?php

namespace App\Http\Controllers;

use App\Models\KosImage;
use Illuminate\Http\Request;

class KosImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kos_id' => 'required',
            'file' => 'required'
        ]);

        return KosImage::create($request->all());
    }

    public function destroy($id)
    {
        KosImage::destroy($id);
        return ['message' => 'Image deleted'];
    }
}

