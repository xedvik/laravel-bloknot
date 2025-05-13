<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Infrastructure\Eloquent\Models\User;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    protected array $validData;

    protected function setUp(): void
    {
        parent::setUp();

        // Стандартные корректные данные
        $this->validData = [
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];
    }

    /** @test */
    public function user_can_register_successfully()
    {
        $response = $this->postJson('/api/register', $this->validData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'token',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function registration_fails_if_password_confirmation_does_not_match()
    {
        $invalidData = $this->validData;
        $invalidData['password_confirmation'] = 'WrongPassword';

        $response = $this->postJson('/api/register', $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function registration_fails_if_email_already_taken()
    {
        User::factory()->create([
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'Password1232',
        ]);

        $response = $this->postJson('/api/register', $this->validData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
}
