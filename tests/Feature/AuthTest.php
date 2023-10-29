<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function test_valid_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_invalid_login_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('api/login', [
                'email' => 'invalid@example.com',
                'password' => 'password123',
        ]);

        

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_invalid_login_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('api/login', [
                'email' => 'test@example.com',
                'password' => 'invalidpassword',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_missing_credentials()
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('api/login', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }
}
