<?php

namespace App\Notifications;

use App\Book;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookDeleted extends Notification implements ShouldQueue
{
    use Queueable;
    private $userName,$bookName,$authorName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {      
        $this->bookName = $book->name;
        $this->authorName = $book->author;
        $this->userName = $book->user->name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {        
        return (new MailMessage)
                    ->line('Hi '.$this->userName)
                    ->line('You have Deleted Following book from your list')
                    ->line('Book Name: '.$this->bookName)
                    ->line('Book Author: '.$this->authorName);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
