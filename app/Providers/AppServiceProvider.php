<?php

namespace App\Providers;

use View;
use Auth;
use Laravel\Dusk\DuskServiceProvider;
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
            $notifications = Auth::user()->notifications->where('read', false)->where('type', 'danger');
            foreach($notifications as $notification) {
                $notification->read = 1;
                $notification->save();
            }
            $view->with('notifications', $notifications);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
