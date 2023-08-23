<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    protected $token = "";

    use DatabaseMigrations;

    public function setUp(): void 
    {
        parent::setUp();
        $this->seed();
        $this->token = $this->getAuthToken();
    }

    public function testCategoryIndexReturnsItems()
    {               
        
    $this->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token])
            ->json('get', 'api/category')
            ->assertStatus(200);
    }

    public function testCategoryIsCreated()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token])
        ->json('post', 'api/category', [
            "name" => "New Category Testing"
        ])
        ->assertStatus(201);
    }

    public function testCategoryIsUpdated()
    {
        
        $category = Category::where('user_id', 1)->first();
   
        $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token])
        ->json('put', 'api/category/'. $category->id, [
            "name" => "Category Update"
        ])
        ->assertStatus(201);
    }

    public function testCategoryisDeleted()
    {

    }
    private function getAuthToken()
    {
        $user = User::find(1);

        $payload = [
            "email" => $user->email,
            "password" => "password"
        ];
                
        $response = $this->json('post', 'api/login', $payload);
            
        return json_decode($response->getContent())->token;
    }

}
