<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'category_id' => 1,
            'title' => fake()->unique()->sentence(3),
            'description' => fake()->text,
            'due_date' => fake()->dateTimeBetween('now', '+15 days'),
            'task_priority_id' => fake()->numberBetween(1, 3),
            'task_status_id' => fake()->numberBetween(1, 3)
        ];
    }
}
