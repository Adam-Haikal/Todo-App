<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // // Fetch all tasks with pagination
        $tasks = Task::latest()
            ->simplePaginate(15)
            ->getCollection()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'task_name' => $task->task_name,
                ];
            });
        // $tasks = Task::latest()->get();

        return response()->json($tasks);
        // $list = Task::latest()->simplePaginate(9);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
        ]);

        Task::create([
            'task_name' => $request->task_name,
        ]);

        // return response()->noContent();
        return response()->json(['message' => 'Task created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // check if task is created by the user, if yes then delete
        if ($task->user_id == auth()->user()->id) {
            $task->delete();
            // return response()->noContent();
            return response()->json(['message' => 'Task deleted successfully'], 204);
        }
        return response()->json(['message' => 'You do not have permission to delete this task'], 403);
    }
}
