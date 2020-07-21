<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = $request->user()->books()->latest()->get()->toArray();
        return $books;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $book = new Book([
            'name'    => $request->input('name'),
            'author'  => $request->input('author'),
            'user_id' => $request->user()->id,
        ]);
        $book->save();
        return response()->json('The book successfully added');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $book = Book::find($request->input('id'));
        $book->update([
            'name'   => $request->input('name'),
            'author' => $request->input('author'),
        ]);

        return response()->json('The book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::withTrashed()->where('id', $id)->first();
        if ($book->trashed()) {
            $book->forceDelete();
        }
        $book->delete();

        return response()->json('The book successfully deleted');
    }

    public function getDeleted(Request $request)
    {
        $books = $request->user()->books()->onlyTrashed()->latest('deleted_at')->get()->toArray();
        return $books;
    }

    public function restoreBook($id)
    {
        $books = Book::onlyTrashed()->where('id', $id)->first();
        $books->restore();
        return response()->json('The book successfully restored');
    }
}
