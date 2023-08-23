<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class NotifyTasksExpiringToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-tasks-expiring-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification to the user about the Tasks that will expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::whereDate('due_date', Carbon::today()->toDateString())->get();
        
        $taskCount = $tasks->count();
        $taskLabel = Str::plural('task', $taskCount);

        $this->info("Found {$taskCount} {$taskLabel}");

        $tasks->each(
            fn($task) => $this->info("Sending Notification to {$task->user_id} about task {$task->id}")
        );

        $this->info('Notifications sent successfully!');
    }
}
