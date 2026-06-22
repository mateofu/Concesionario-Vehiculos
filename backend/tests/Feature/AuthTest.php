<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials(): void
    {
        User::factory()->create([
            'email'    => 'admin@taller.co',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => 'admin@taller.co',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'token', 'user'])
                 ->assertJsonPath('user.email', 'admin@taller.co');
    }

    public function test_login_fails_with_invalid_password(): void
    {
        User::factory()->create([
            'email'    => 'admin@taller.co',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => 'admin@taller.co',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_fails_with_non_existent_email(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => 'noexiste@taller.co',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_requires_email_and_password(): void
    {
        $response = $this->postJson('/api/v1/auth/login', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_authenticated_user_can_access_me_endpoint(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
                 ->assertJsonPath('email', $user->email);
    }

    public function test_unauthenticated_request_returns_401(): void
    {
        $response = $this->getJson('/api/v1/auth/me');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withToken($token)
                         ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
                 ->assertJsonPath('message', 'Sesión cerrada exitosamente.');
    }
}
