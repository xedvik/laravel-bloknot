<?php

namespace Tests\Feature\Api\Auth;

use App\Infrastructure\Eloquent\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_receive_token()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->postJson(
            '/api/login',
            [
                'email' => 'test@example.com',
                'password' => '12345678',
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'token'
        ]);
        $this->assertArrayHasKey('token', $response->json());
    }
    public function test_login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->postJson(
            '/api/login',
            [
                'email' => 'test@example.com',
                'password' => 'wrong_12345678',
            ]
        );

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
        $response->assertJson([
            'status' => 'error',
            'message' => 'invalid credentials',
        ]);
    }
}