<?php

use App\Models\Task;
use App\Models\ListTask;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('lists', ['lists' => ListTask::all()]);
});

Route::get('/tasks/{id}', function ($id) {
    $listTask = ListTask::find($id);
    $task = $listTask->tasks;

    return view('/tasks', ['tasks' => $task]);
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