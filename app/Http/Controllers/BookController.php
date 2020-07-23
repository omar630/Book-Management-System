<?php

namespace App\Http\Controllers;

use App\Book;
use DB;
use Illuminate\Http\Request;
use App\Http\Resources\BooksCollection;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = $request->user()->books()->latest()->get();
        return new BooksCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Book([
            'name'    => $request->input('name'),
            'author'  => $request->input('author'),
            'user_id' => $request->user()->id,
        ]);

        DB::transaction(function () use($book) {
            $book->save();
        });

        return response()->json('The book successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Book $book, Request $request)
    {
        DB::transaction(function () use($book,$request) {

            $book->update([
                'name'   => $request->input('name'),
                'author' => $request->input('author'),
            ]);
        });

        return response()->json('The book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        $book = Book::withTrashed()->find($id);
        if ($book->trashed()) {

            DB::transaction(function () use($book) {

                $book->forceDelete();
            });
        }        
        DB::transaction(function () use($book) {

            $book->delete();
        });
        return response()->json('The book successfully deleted');
    }

    /**
     * Display SoftDeleted resources
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDeleted(Request $request)
    {
        $books = $request->user()->books()->onlyTrashed()->latest('deleted_at')->get();
        return new BooksCollection($books);
    }
    
    /**
     * restore softdeleted resource
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function restoreBook($id)
    {
        $book = Book::onlyTrashed()->where('id', $id)->first();
        DB::transaction(function () use($book) {

            $book->restore();
        });        
        return response()->json('The book successfully restored');
    }
}
