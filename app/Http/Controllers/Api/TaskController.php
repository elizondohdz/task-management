<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth:sanctum');
        $this->middleware('throttle:60,1');
        $this->authorizeResource(Task::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $tasks = $category->tasks;

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        $task = $category->tasks()->create([
            ... $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'due_date' => 'required|date',
                'task_priority_id' => 'required|integer|min:1|max:3',
                'task_status_id' => 'required|integer|min:1|max:3',
                'user_id' => 'required|exists:users,id'
            ]),
            'category_id' => $category->id
        ]);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, Task $task)
    {
        $task->update(
            $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:255',
                'due_date' => 'sometimes|date',
                'task_priority_id' => 'sometimes|integer|min:1|max:3',
                'task_status_id' => 'sometimes|integer|min:1|max:3'
            ])
        );

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Task $task)
    {
        $task->delete();

        return response(status: 204);
    }
}
