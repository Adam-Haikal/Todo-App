<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
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
        /* Check if the authenticated user owns the parent task */
        $task = Task::find($request->task_id);
        if (!$task || $task->user_id !== auth()->id()) {
            return response()->json(['message' => 'You do not have permission to create a subtask for this task'], 403);
        }

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
        // Only allow update if the authenticated user owns the parent task
        if ($subtask->task->user_id !== auth()->id()) {
            return response()->json(['message' => 'You do not have permission to update this subtask'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'completed' => 'sometimes|boolean',
            'completed_at' => 'nullable|date',
        ]);

        $updatedData = [
            'name' => $request->name,
        ];

        if ($request->has('completed')) {
            $updatedData['completed'] = $request->completed;
            $updatedData['completed_at'] = $request->completed ? now() : null;
        }

        $subtask->update($updatedData);

        return response()->json(['subtask' => $subtask, 'message' => 'Subtask updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        /* Only allow delete if the authenticated user owns the parent task */
        if ($subtask->task->user_id !== auth()->id()) {
            return response()->json(['message' => 'You do not have permission to delete this subtask'], 403);
        }

        $subtask->delete();
        return response()->json(['message' => 'Subtask deleted successfully'], 204);
    }
}
