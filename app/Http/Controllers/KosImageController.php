<?php

namespace App\Http\Controllers;

use App\Models\KosImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KosImageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // simpan file ke storage/app/public/kos
        $path = $request->file('file')->store('kos', 'public');

        $image = KosImage::create([
            'kos_id' => $validated['kos_id'],
            'file' => $path,
        ]);

        return response()->json([
            'status' => true,
            'data' => $image
        ], 201);
    }

    public function destroy($id)
    {
        $image = KosImage::findOrFail($id);

        // hapus file fisik
        if ($image->file && Storage::disk('public')->exists($image->file)) {
            Storage::disk('public')->delete($image->file);
        }

        $image->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted'
        ]);
    }
}
