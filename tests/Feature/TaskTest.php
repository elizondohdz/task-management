<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Database\Seeders\TaskPrioritySeeder;
use Database\Seeders\TaskStatusSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->seed(TaskPrioritySeeder::class);
        $this->seed(TaskStatusSeeder::class);

    }

    public function test_index_returns_task_list()
    {
        $tasks = Task::factory(3)->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->user)
            ->get("/api/category/{$this->category->id}/task");

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(3, $data);
    }

    public function test_store_creates_new_task()
    {
        $data = [
            'title' => 'New Task',
            'description' => 'Task description',
            'due_date' => now()->addDay(),
            'task_priority_id' => 1,
            'task_status_id' => 1,
            'user_id' => $this->user->id,
        ];
        
        $dataCompared = [
            'title' => 'New Task',
            'description' => 'Task description',
        ];

        $response = $this->actingAs($this->user)
            ->post("/api/category/{$this->category->id}/task", $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($dataCompared);
    }

    public function test_show_displays_task()
    {
        $task = Task::factory()->create(['category_id' => $this->category->id]);
        $this->seed(TaskPrioritySeeder::class);
        $this->seed(TaskStatusSeeder::class);

        $response = $this->actingAs($this->user)
            ->get("/api/category/{$this->category->id}/task/{$task->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_update_updates_task()
    {
        $task = Task::factory()->create(['category_id' => $this->category->id]);
        $newData = [
            'title' => 'Updated Task',
        ];

        $response = $this->actingAs($this->user)
            ->put("/api/category/{$this->category->id}/task/{$task->id}", $newData);

        $response->assertStatus(200);
        $response->assertJsonFragment($newData);
    }

    public function test_destroy_deletes_task()
    {
        $task = Task::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->user)
            ->delete("/api/category/{$this->category->id}/task/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_policy_denied_access_task()
    {
        $task = Task::factory()->create(['category_id' => $this->category->id]);
        $newData = [
            'title' => 'Updated Task',
        ];

        $differentUser = User::factory()->create();

        $response = $this->actingAs($differentUser)
            ->put("/api/category/{$this->category->id}/task/{$task->id}", $newData);

        $response->assertStatus(403);
        $this->assertStringContainsString("This action is unauthorized", $response->getContent());
    }

    public function test_policy_denied_access_destroy_task()
    {
        $task = Task::factory()->create(['category_id' => $this->category->id]);
        $differentUser = User::factory()->create();

        $response = $this->actingAs($differentUser)
            ->delete("/api/category/{$this->category->id}/task/{$task->id}");

        $response->assertStatus(403);
        $this->assertStringContainsString("This action is unauthorized", $response->getContent());
    }

}
