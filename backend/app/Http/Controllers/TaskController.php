<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        /* Display tasks for specific user */
        $tasks = Task::with('tags')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        /* Authorization: Only allow if user is authenticated */
        if (!auth()->check()) {
            return response()->json(['message' => 'You do not have permission to create a task'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task = Task::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['task' => $task, 'message' => 'Task created successfully'], 201);
    }

    public function update(Request $request, Task $task)
    {
        /* Authorization: Only allow if user owns the task */
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'You do not have permission to update this task'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task->update([
            'name' => $request->name,
        ]);

        return response()->json(['task' => $task, 'message' => 'Task updated successfully'], 200);
    }

    public function destroy(Task $task)
    {
        /* Authorization: Only allow if user owns the task */
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'You do not have permission to delete this task'], 403);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 204);
    }

    public function show(Task $task)
    {
        /* Check if the authenticated user is the owner */
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($task);
    }

    public function attachTag(Request $request, Task $task)
    {
        /* Authorize: Only allow if user owns the task */
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        $request->validate([
            'tag_id' => 'required|exists:tags,id',
        ]);

        $tagId = $request->tag_id;

        /* This will only attach if not already attached */
        $task->tags()->syncWithoutDetaching([$tagId]);

        // $task->tags()->attach($request->tag_id);
        return response()->json(['tags' => $task->tags, 'message' => 'Tag attached successfully'], 200);
    }
}
