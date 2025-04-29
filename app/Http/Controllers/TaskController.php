<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ListTask;
use Illuminate\Http\Request;

class TaskController extends Controller {

    public function index($id) {
        // Find the list to ensure it exists
        $list = ListTask::with(['tasks' => function ($query) {
            $query->latest(); // Order by created_at in descending order
        }])->findOrFail($id);

        return view('tasks.index', ['tasks' => $list->tasks, 'list' => $list]);
    }

    public function create(Request $request, $id) {
        $request->validate([
            'task_name' => 'required',
            'description' => 'nullable',
            'is_completed' => 'nullable|boolean'
        ]);

        // Find the list to ensure it exists
        $list = ListTask::findOrFail($id);

        // Add task to the list
        $list->tasks()->create([
            'task_name' => $request->input('task_name'),
            'description' => $request->input('description'),
            'is_completed' => $request->has('is_completed') ? true : false
        ]);

        return redirect()->route('tasks.index', $id)->with('success', 'Task added successfully.');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'task_name' => 'required|string',
            'description' => 'nullable|string',
            'is_completed' => 'nullable|boolean'
        ]);

        // Find the task to ensure it exists
        $task = Task::findOrFail($request->task_id);

        // Update task details
        $task->update([
            'task_name' => $request->input('task_name'),
            'description' => $request->input('description'),
            'is_completed' => $request->has('is_completed')
        ]);

        // return redirect()->route('tasks.show', $task->list_task_id)->with('success', 'Task updated successfully!');
        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    public function destroy(Request $request, $id) {
        $request->validate([
            'delete_task_ids' => 'required|array', // Ensures 'delete_task_ids' is present and is an array
            'delete_task_ids.*' => 'exists:task_listings,id' // Ensures each element in the 'delete_task_ids' array exists in the 'task_listings' table under the 'id' column
        ]);

        // Find the list to ensure it exists
        $list = ListTask::findOrFail($id);

        // Delete the selected tasks that belong to the specified list
        Task::whereIn('id', $request->input('delete_task_ids'))->where('list_task_id', $list->id)->delete();

        return redirect()->route('tasks.index', $id)->with('success', 'Tasks deleted successfully.');
    }
}
