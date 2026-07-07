<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_user_and_logs_them_in(): void
    {
        $response = $this->post('/register', [
            'name' => 'Benny',
            'email' => 'benny@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'benny@example.com',
            'name' => 'Benny',
        ]);
    }

    public function test_login_accepts_registered_user_credentials(): void
    {
        $user = User::create([
            'name' => 'Benny',
            'email' => 'benny@example.com',
            'password' => 'password123',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertAuthenticatedAs($user);
    }
}
