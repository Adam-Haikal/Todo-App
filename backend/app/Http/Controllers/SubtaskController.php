<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // // Fetch all tasks with pagination
        $tasks = Subtask::latest()
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

        Subtask::create([
            'task_name' => $request->task_name,
        ]);

        // return response()->noContent();
        return response()->json(['message' => 'Task created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtask $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $task)
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
