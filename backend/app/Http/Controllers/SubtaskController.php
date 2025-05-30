<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Display tasks for specific user
        $taskId = $request->query('task_id');
        // $subtasks = Subtask::where('user_id', auth()->id())
        //     ->where('task_id', $taskId)
        //     ->latest()
        //     ->get();

        $subtasks = Subtask::where('task_id', $taskId)
            ->whereHas('task', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return response()->json($subtasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $completedAt = $request->completed ? now() : null;

        $subtask = Subtask::create([
            'name' => $request->name,
            'task_id' => $request->task_id,
            'completed' => $request->completed,
            'completed_at' => $completedAt,
        ]);

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
        /* check if subtask is created by the user, if yes then delete */
        if ($subtask->user_id == auth()->user()->id) {
            $subtask->delete();
            return response()->json(['message' => 'Subtask deleted successfully'], 204);
        }
        return response()->json(['message' => 'You do not have permission to delete this subtask'], 403);
    }
}
