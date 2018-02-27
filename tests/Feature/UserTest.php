<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testLogin()
    {
        $user = factory(User::class)->create([
             'email' => 'jofdfdfhn@example.com', 
             'password' => bcrypt('testpass123')
        ]);
        
        $this->browse(function ($browser) {
            $browser->visit(route('login'))
            ->type($user->email, 'email')
            ->type('testpass123', 'password')
            ->press('Let\'s Go')
            ->onPage('/step2');
        });
        
    }
}
