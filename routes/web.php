<?php

use App\Models\Task;
use App\Models\ListTask;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('tasks', ['tasks' => Task::all()]);
    return view('lists', ['lists' => ListTask::all()]);
});

Route::get('/tasks/{id}', function ($id) {
    return view('/tasks', ['tasks' => Task::find($id) ]);
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