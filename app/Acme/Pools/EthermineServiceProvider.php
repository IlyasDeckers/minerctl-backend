<?php
namespace App\Acme\Pools;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class EthermineServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('ethermine', function() {
            return new \App\Acme\Pools\Ethermine;
        });
    }
}