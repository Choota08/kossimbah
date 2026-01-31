<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // CREATE (USER BOOK KOS)
    public function store(Request $request)
    {
        return Book::create([
            'kos_id' => $request->kos_id,
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending'
        ]);
    }

    // UPDATE STATUS (OWNER)
    public function updateStatus(Request $request, $id)
    {
        $booking = Book::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return response()->json($booking);
    }

    // DELETE
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return response()->json(['message' => 'Booking deleted']);
    }
}
