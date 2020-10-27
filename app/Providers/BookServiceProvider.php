<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('rakuten-book', 'App\Library\RakutenBook');
        $this->app->bind('common', 'App\Library\BookReviewCommon');
        $this->app->bind('env-conf', 'App\Library\EnvironmentalConfirmation');
        $this->app->bind('image-process', 'App\Library\ImageProccesing');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
