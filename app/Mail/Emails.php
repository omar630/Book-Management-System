<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Emails extends Mailable
{
    use Queueable, SerializesModels;
    public $book, $desc;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($book, $desc = 'deleted')
    {
        $this->book = $book;
        $this->desc = $desc;
        \Log::info('Email cons');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.book-add')->with(['book' => $this->book, 'desc' => $this->desc]);
    }
}
