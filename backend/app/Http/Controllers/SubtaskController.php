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
        $subtasks = Subtask::latest()
            ->simplePaginate(15)
            ->getCollection()
            ->map(function ($subtasks) {
                return [
                    'id' => $subtasks->id,
                    'subtask_name' => $subtasks->subtask_name,
                ];
            });
        // $tasks = Task::latest()->get();

        return response()->json($subtasks);
        // $list = Task::latest()->simplePaginate(9);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subtask_name' => 'required|string|max:255',
        ]);

        $completedAt = $request->completed ? now() : null;

        $subtask = Subtask::create([
            'subtask_name' => $request->subtask_name,
            'task_id' => $request->subtask_id,
            'completed' => $request->completed,
            'completed_at' => $completedAt,
        ]);

        // return response()->noContent();
        return response()->json(['subtask' => $subtask, 'message' => 'Subtask created successfully'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtask $subtask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        // check if task is created by the user, if yes then delete
        if ($subtask->user_id == auth()->user()->id) {
            $subtask->delete();
            // return response()->noContent();
            return response()->json(['message' => 'Subtask deleted successfully'], 204);
        }
        return response()->json(['message' => 'You do not have permission to delete this subtask'], 403);
    }
}
