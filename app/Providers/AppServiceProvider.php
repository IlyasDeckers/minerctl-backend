<?php

namespace App\Providers;

use View;
use Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer(['dashboard', 'rigs', 'pools', 'createWallet', 'wallet', 'createwallet', 'userprofile'], function($view)
        {
            $view->with('notifications', Auth::user()->notifications);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
