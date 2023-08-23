<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all()->random(20);

        foreach ($users as $user) {
            \App\Models\Category::factory()->create([
                'user_id' => $user->id
            ]);
        }

        // Create user_id on 1 for testing purposes

        \App\Models\Category::factory()->create([
            'user_id' => 1
        ]);



    }
}
