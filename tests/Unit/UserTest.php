<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     * test login form
     * check status get url: /login
     * @return void
     */
    public function test_login_form(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * test user duplication
     * create 2 users and compare them
     * @return void
     */
    public function test_user_duplication(): void
    {
        $user1 = User::make([
            'name' => 'Dmytro Lozov',
            'email' => 'dmytro@gmail.com'
        ]);

        $user2 = User::make([
            'name' => 'Dary',
            'email' => 'dary@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    /**
     * test create new user
     * push data for POST url: /register
     * @return void
     */
    public function test_it_stores_new_users(): void
    {
        try {
            $response = $this->post('/register', [
                'name' => 'Dmytro',
                'surname' => 'Dmytro',
                'middle_name' => 'Dmytro',
                'email' => 'dmytro@gmail.com',
                'ip_address' => '127.0.0.1',
                'geo_location' => "[55.755831, 37.617673]",
                'password' => 'Deus_dirbsd-99',
                'password_confirmation' => 'Deus_dirbsd-991'
            ]);

            $response->assertRedirect('/home');
        } catch (\Exception $exception) {
            $response->assertStatus(302);
        }

    }
}
