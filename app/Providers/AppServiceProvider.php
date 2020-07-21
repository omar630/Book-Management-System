<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Observers\BookObserver;
use App\Book;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Book::observe(BookObserver::class);
    }
}
