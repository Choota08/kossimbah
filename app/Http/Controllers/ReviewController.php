<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kos_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required'
        ]);

        return Review::create($request->all());
    }

    public function destroy($id)
    {
        Review::destroy($id);
        return ['message' => 'Review deleted'];
    }
}

