<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_duplication()
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

    public function test_it_stores_new_users()
    {
        $response = $this->post('/register', [
            'name' => 'Dmytro',
            'surname' => 'Dmytro',
            'middle_name' => 'Dmytro',
            'email' => 'dmytro@gmail.com',
            'ip_address' => $_SERVER["REMOTE_ADDR"],
            'geo_location' => "[55.755831, 37.617673]",
            'password' => 'Deus_dirbsd-99',
            'password_confirmation' => 'Deus_dirbsd-991'
        ]);

        $response->assertRedirect('/home');
    }

    public function test_if_seeder_works()
    {
        $this->seed();
    }
}
