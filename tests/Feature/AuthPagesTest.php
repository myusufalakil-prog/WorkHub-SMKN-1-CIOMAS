<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_sees_login_and_register_buttons_on_home_and_portal()
    {
        $this->seed(DatabaseSeeder::class);

        // Home Page
        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('Masuk (Login)');
        $home->assertSee('Daftar (Register)');

        // Portal Page
        $portal = $this->get('/portal');
        $portal->assertStatus(200);
        $portal->assertSee('Masuk (Login)');
        $portal->assertSee('Daftar (Register)');

        // Login Page
        $login = $this->get('/login');
        $login->assertStatus(200);
        $login->assertSee('Masuk ke WORKHUB');
        $login->assertDontSee('admin@gmail.com');

        // Register Page
        $register = $this->get('/register');
        $register->assertStatus(200);
        $register->assertSee('Daftar Sekarang & Masuk', false);
    }
}
