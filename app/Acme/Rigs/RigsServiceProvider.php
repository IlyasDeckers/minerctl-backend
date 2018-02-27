<?php
namespace App\Acme\Rigs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class RigsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('rigs', function() {
            return new \App\Acme\Rigs\Rigs;
        });
    }
}