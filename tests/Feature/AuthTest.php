<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // public function test_user_can_register(): void
    // {
    //     $userData = [
    //         'email' => 'test@example.com',
    //         'password' => 'password123',
    //         'role' => 'member'
    //     ];

    //     $response = $this->postJson('/api/register', $userData);

    //     $response->assertStatus(200)
    //             ->assertJsonStructure([
    //                 'user',
    //                 'token'
    //             ]);
    // }

    public function test_user_can_login(): void
    {
        $user = User::create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member'
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'user',
                    'token'
                ]);
    }
} 