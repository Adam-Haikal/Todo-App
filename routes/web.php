<?php

use App\Models\Task;
use App\Models\ListTask;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', function () {
    return view('tasks.index', ['lists' => ListTask::latest()->simplePaginate(9)]);
});

Route::get('/tasks/create', function () {
    return view('tasks.create');
});

Route::get('/tasks/{id}', function ($id) {
    $listTask = ListTask::find($id);
    $task = $listTask->tasks;

    return view('tasks.show', ['tasks' => $task]);
});

Route::post('/tasks', function () {
    //validation
    
    Task::create([
        'list'=> request('list'),
        'task'=> request('task'),
        'description'=> request('description'),
    ]);

    return redirect('/tasks');
});

Route::get('/important', function () {
    return view('important');
});

Route::get('/planned', function () {
    return view('planned');
});

Route::get('/assigned', function () {
    return view('assigned');
});

Route::get('/flagged', function () {
    return view('flagged');
});