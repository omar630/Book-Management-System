<?php

namespace Tests\Feature;

use App\Book;
use App\User;

use Tests\TestCase;

use App\Notifications\BookAdded;
use App\Notifications\BookDeleted;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;

use Laravel\Passport\Passport;

class BookTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    private $user;

    /**
     * creates a user and add two books on every test
     */
    public function setUp(): void
    {          
        parent::setUp();

        Passport::actingAs(
            factory(User::class)->create(),
            ['']
        );       
        $this->user = User::first();
        
        Notification::fake();
        Notification::assertNothingSent();
        //1st book creation
        $this->post('/api/book',['name' => $this->faker->name, 'author' => $this->faker->name]);

        Notification::assertSentTo(
            [$this->user], BookAdded::class
        );

        //2nd book creation
        $this->post('/api/book',['name' => $this->faker->name, 'author' => $this->faker->name]);

        Notification::assertSentTo(
            [$this->user], BookAdded::class
        );
        
    }

    /**
     * verifies response json parameter value after adding two books
     */
    public function testAddedBook()
    {        
        //get all created books by authenticated user
        $response = $this->get('/api/book');

        $response->assertJsonCount(2,'data')->assertJsonFragment(['book_count' => 2])->assertOk();
    }

    /**
     * Soft Deleting book
     */

    public function testSoftDeletingBook()
    {        
        //get all created books by authenticated user
        $response = $this->get('/api/book');

        $response->assertJsonCount(2,'data')->assertOk();
        
        Notification::fake();

        //soft deleting book
        $response = $this->delete('/api/book/'.Book::first()->id);

        Notification::assertSentTo(
            [$this->user], BookDeleted::class
        );
        
        //get all created books by authenticated user
        $response = $this->get('/api/book');
        $response->assertJsonCount(1,'data');

        //check count with trashed books
        $this->assertCount(2,Book::withTrashed()->get());

    }

    /**
     * Delete a book(softdelete) and restore then checks count or books after restore
     */
    public function testRestoreDeletedBook()
    {        
        //get all created books by authenticated user
        $response = $this->get('/api/book');

        $response->assertJsonCount(2,'data');

        //soft deleting book
        $response = $this->delete('/api/book/'.Book::first()->id);
        
        //get all created books by authenticated user
        $response = $this->get('/api/book');
        $response->assertJsonCount(1,'data');

        //restoring soft deleted book
        $response = $this->get('/api/book/'.Book::withTrashed()->first()->id.'/restore');

        //get all created books by authenticated user
        $response = $this->get('/api/book');
        $response->assertJsonCount(2,'data');
    }

    /**
     * Edit book and verifies changes
     */
    public function testEditBook(){

        $book = Book::first();

        //edit book
        $response = $this->put('/api/book/'.$book->id,['name' => $book->name.'edit', 'author' => $book->author.'edit']);

        //get edited book
        $response = $this->get('/api/book/'.$book->id);

        //verify edited book
        $response->assertJsonFragment(['name' => $book->name.'edit', 'author' => $book->author.'edit']);
        $response->assertOk();
    }
}
