<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();
        $task_priorities = TaskPriority::all();
        $task_statuses = TaskStatus::all();
        $projects = Project::all();

        foreach ($categories as $category) {
            for ($i=0; $i < rand(1, 10); $i++) { 
                $user = $users->random();
                Task::factory()->create ([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'project_id' => $projects->random()->id,
                    'task_priority_id' => $task_priorities->random(),
                    'task_status_id' => $task_statuses->random(),
                    'assigned_to_user_id' => $users->random()->id
                ]);
            }
        }
    }
}
