<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'comment' => 'required|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $review = Review::create([
            'kos_id' => $request->kos_id,
            'user_id' => Auth::id(), // ✅ AMAN
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Review berhasil ditambahkan',
            'data' => $review,
        ], 201);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->update([
            'comment' => $request->comment,
        ]);

        return response()->json($review);
    }

    // DELETE
    public function destroy($id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->delete();

        return response()->json([
            'message' => 'Review deleted'
        ]);
    }
}
