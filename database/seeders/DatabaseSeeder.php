<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {        
        \App\Models\User::factory(100)->create();

        $this->call(TaskStatusSeeder::class);
        $this->call(TaskPrioritySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(TaskSeeder::class);

    }
}
