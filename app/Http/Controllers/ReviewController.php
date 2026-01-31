<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // CREATE
    public function store(Request $request)
    {
        return Review::create([
            'kos_id' => $request->kos_id,
            'user_id' => $request->user_id,
            'comment' => $request->comment
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update(['comment' => $request->comment]);

        return response()->json($review);
    }

    // DELETE
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return response()->json(['message' => 'Review deleted']);
    }
}

