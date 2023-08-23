<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void 
    {
        parent::setUp();
        $this->seed();
    }

    public function testSuccessfullLogin()
    {
        $user = User::take(1)->first();

        $payload = [
            "email" => $user->email,
            "password" => "password"
        ];
                
        $this->json('post', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'token'
                ]
            );
    }

    public function testIncorrectLogin()
    {
        $user = User::take(1)->first();

        $payload = [
            "email" => $user->email,
            "password" => "notpassword"
        ];
                
        $this->json('post', 'api/login', $payload)
            ->assertStatus(422)
            ->assertJsonStructure(
                [
                    'message',
                    "errors" => [
                        "email"
                    ]
                ]
            );
    }
    
}
