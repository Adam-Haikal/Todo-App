<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ListTask;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index() {
        // Fetch all lists with pagination
        $list = ListTask::latest()->simplePaginate(9);

        return view('tasks.index', ['lists' => $list]);
    }

    public function show($id) {
        // Find the list to ensure it exists
        $list = ListTask::with(['tasks' => function ($query) {
            $query->latest(); // Order by created_at in descending order
        }])->findOrFail($id);

        return view('tasks.show', ['tasks' => $list->tasks, 'list' => $list]);
    }

    public function createList(Request $request) {
        $request->validate([
            'list_name' => 'required',
            'task_name' => 'nullable',
            'description' => 'nullable',
        ]);

        // Create a new list
        $list = ListTask::create([
            'list_name' => $request->input('list_name'),
        ]);

        // Only creteate a task if 'task_name' is provided
        if ($request->filled('task_name')) {
            $list->tasks()->create([
                'list_task_id' => $list->id,
                'task_name' => $request->input('task_name'),
                'description' => $request->input('description'),
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'List and task created successfully!');
    }
    public function updateList(Request $request, $id) {
        $request->validate([
            'list_name' => 'required|string',
            'is_completed' => 'nullable|boolean'
        ]);

        // Find the task to ensure it exists
        $list = ListTask::findOrFail($id);

        dd('Before Update:', $list->toArray(), $request->all());

        // Update task details
        $list->update([
            'list_name' => $request->input('list_name'),
            'is_completed' => $request->has('is_completed')
        ]);

        dd('After Update:', $list->toArray());

        return redirect()->route('tasks.index')->with('success', 'List updated successfully!');
    }

    public function destroyList(Request $request) {
        $request->validate([
            'delete_list_ids' => 'required|array', // Ensures 'delete_list_ids' is present and is an array
            'delete_list_ids.*' => 'exists:list_tasks,id' // Ensures each element in the 'delete_list_ids' array exists in the 'list_tasks' table under the 'id' column
        ]);

        // Delete the selected lists
        ListTask::whereIn('id', $request->input('delete_list_ids'))->delete();

        return redirect()->route('tasks.index')->with('success', 'Lists deleted successfully.');
    }

    public function createTask(Request $request, $id) {
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

        return redirect()->route('tasks.show', $id)->with('success', 'Task added successfully.');
    }

    public function updateTask(Request $request, $id) {
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

    public function destroyTask(Request $request, $id) {
        $request->validate([
            'delete_task_ids' => 'required|array', // Ensures 'delete_task_ids' is present and is an array
            'delete_task_ids.*' => 'exists:task_listings,id' // Ensures each element in the 'delete_task_ids' array exists in the 'task_listings' table under the 'id' column
        ]);

        // Find the list to ensure it exists
        $list = ListTask::findOrFail($id);

        // Delete the selected tasks that belong to the specified list
        Task::whereIn('id', $request->input('delete_task_ids'))->where('list_task_id', $list->id)->delete();

        return redirect()->route('tasks.show', $id)->with('success', 'Tasks deleted successfully.');
    }
}
