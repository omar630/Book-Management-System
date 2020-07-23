<?php

namespace App\Observers;

use App\Book;
use App\Mail\Emails;
use App\Notifications\BookAdded;
use App\Notifications\BookDeleted;
use Mail;

class BookObserver
{
    /**
     * Handle the book "created" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function created(Book $book)
    {
        $book->user->notify(new BookAdded($book));
        \Log::info('Email queued to ' . ($book->user['email']));        
    }

    /**
     * Handle the book "updated" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function updated(Book $book)
    {
        //
    }

    /**
     * Handle the book "deleted" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
        $book->user->notify(new BookDeleted($book));
        \Log::info('Email queued to ' . $book->user->email);
    }

    /**
     * Handle the book "restored" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function restored(Book $book)
    {
        //
    }

    /**
     * Handle the book "force deleted" event.
     *
     * @param  \App\Book  $book
     * @return void
     */
    public function forceDeleted(Book $book)
    {

    }
}
