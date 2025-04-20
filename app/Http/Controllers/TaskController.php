<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ListTask;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index() {
        $list = ListTask::latest()->simplePaginate(9);

        return view('tasks.index', ['lists' => $list]);
    }

    public function show($id) {
        $list = ListTask::findOrFail($id);
        $task = $list->tasks;

        return view('tasks.show', ['tasks' => $task, 'list' => $list]);
    }

    public function store(Request $request) {
        $request->validate([
            'list_name' => 'required',
            'task_name' => 'nullable',
            'description' => 'nullable',
        ]);

        $list = ListTask::create([
            'list_name' => $request->input('list_name'),
            // 'list_name' => $validated('list'),
        ]);

        // Task::create([
        $list->tasks()->create([
            'list_task_id' => $list->id,
            'task_name' => $request->input('task_name'),
            'description' => $request->input('description'),
        ]);

        // return redirect('tasks.index');
        return redirect()->route('tasks.index')->with('success', 'List and task created successfully!');
    }

    public function addTask(Request $request, $id) {
        $request->validate([
            'task_name' => 'required',
            'description' => 'nullable',
        ]);

        $list = ListTask::findOrFail($id);

        // Add task to the list
        $list->tasks()->create([
            'task_name' => $request->input('task_name'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('tasks.show', $id)->with('success', 'Task added successfully.');
    }
}
