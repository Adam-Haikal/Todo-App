<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ListTask;
use Illuminate\Http\Request;

class ListController extends Controller {
    public function index() {
        // Fetch all lists with pagination
        $list = ListTask::latest()->simplePaginate(9);

        return view('lists.index', ['lists' => $list]);
    }

    public function create(Request $request) {
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

        return redirect()->route('lists.index')->with('success', 'List and task created successfully!');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'list_name' => 'required|string',
            'is_completed' => 'nullable|boolean'
        ]);

        // Find the task to ensure it exists
        $list = ListTask::findOrFail($id);

        // Update task details
        $list->update([
            'list_name' => $request->input('list_name'),
            // 'is_completed' => $request->has('is_completed')
        ]);

        return redirect()->route('lists.index')->with('success', 'List updated successfully!');
    }

    public function destroy(Request $request) {
        $request->validate([
            'delete_list_ids' => 'required|array', // Ensures 'delete_list_ids' is present and is an array
            'delete_list_ids.*' => 'exists:list_tasks,id' // Ensures each element in the 'delete_list_ids' array exists in the 'list_tasks' table under the 'id' column
        ]);

        // Delete the selected lists
        ListTask::whereIn('id', $request->input('delete_list_ids'))->delete();

        return redirect()->route('lists.index')->with('success', 'Lists deleted successfully.');
    }
}
