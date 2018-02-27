<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PagesTest extends DuskTestCase
{
    public function testIndexPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('MinerCTL');
        });
    }

    public function testLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Login');
        });
    }

    public function testRegisterPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertSee('Register');
        });
    }
    
    public function testDashboardPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/dashboard')
                ->assertSee('Dashboard');
        });
    }
}   
