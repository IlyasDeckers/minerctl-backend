<?php
namespace App\Acme\Wallets;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class WalletsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('wallets', function() {
            return new \App\Acme\Wallets\Wallets;
        });
    }
}