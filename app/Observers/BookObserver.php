<?php

namespace App\Observers;

use App\Book;
use App\Jobs\SendEmail;
use App\Mail\Emails;
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
        Mail::to($book->user->email)->queue(new Emails($book, 'added'));
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
        Mail::to($book->user->email)->queue(new Emails($book, 'deleted'));
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
        Mail::to($book->user->email)->queue(new Emails($book, 'deleted permanently'));
        \Log::info('Email queued to ' . $book->user->email);
    }
}
