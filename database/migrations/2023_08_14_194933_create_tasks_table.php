<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Category::class);
            $table->string('title');
            $table->longText('description');
            $table->dateTime('due_date');
            $table->foreignIdFor(Project::class);
            $table->foreignIdFor(User::class, 'assigned_to_user_id');
            $table->foreignIdFor(TaskPriority::class);
            $table->foreignIdFor(TaskStatus::class);
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
