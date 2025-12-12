<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::with(['kos', 'user'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kos_id' => 'required',
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:pending,accept,reject'
        ]);

        return Book::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return $book;
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return ['message' => 'Book deleted'];
    }
}
