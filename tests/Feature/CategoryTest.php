<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    public function test_category_index()
    {
        Category::factory(2)->create();

        $response = $this->actingAs($this->user)->get('/api/category');
        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(3, $data);
    }

    public function test_category_store()
    {
        $data = [
            'name' => 'New Category',
        ];

        $response = $this->actingAs($this->user)->post('/api/category', $data);
        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function test_category_show()
    {
        $response = $this->actingAs($this->user)
            ->get("/api/category/{$this->category->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => $this->category->name,
            ],
        ]);
    }

    public function test_category_update()
    {
        $data = [
            'name' => 'Updated Category',
        ];

        $response = $this->actingAs($this->user)
            ->put("/api/category/{$this->category->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function test_category_destroy()
    {
        $response = $this->actingAs($this->user)
            ->delete("/api/category/{$this->category->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['id' => $this->category->id]);
    }

    public function test_category_store_with_invalid_data()
    {
        $data = [
            'name' => '',
        ];

        $response = $this->actingAs($this->user)->withHeaders(['Accept' => 'application/json'])
            ->post('/api/category', $data);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
    }

}
