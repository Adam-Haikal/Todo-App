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
            // $query->orderBy('created_at', 'desc');
            $query->latest(); // Order by created_at in descending order
        }])->findOrFail($id);
        $task = $list->tasks;

        return view('tasks.show', ['tasks' => $task, 'list' => $list]);
    }

    public function store(Request $request) {
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
    public function update(Request $request, $id) {
    }

    public function destroy(Request $request) {
        $request->validate([
            'list_ids' => 'required|array', // Ensures 'list_ids' is present and is an array
            'list_ids.*' => 'exists:list_tasks,id' // Ensures each element in the 'list_ids' array exists in the 'list_tasks' table under the 'id' column
        ]);
        // Delete the selected lists
        ListTask::whereIn('id', $request->input('list_ids'))->delete();

        return redirect()->route('tasks.index')->with('success', 'Lists deleted successfully.');
    }

    public function addTask(Request $request, $id) {
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

    public function deleteTask(Request $request, $id) {
        $request->validate([
            'task_ids' => 'required|array', // Ensures 'task_ids' is present and is an array
            'task_ids.*' => 'exists:task_listings,id' // Ensures each element in the 'task_ids' array exists in the 'task_listings' table under the 'id' column
        ]);
        // Find the list to ensure it exists
        $list = ListTask::findOrFail($id);
        // Delete the selected tasks
        Task::whereIn('id', $request->input('task_ids'))->where('list_task_id', $list->id)->delete();

        return redirect()->route('tasks.show', $id)->with('success', 'Tasks deleted successfully.');
    }
}
