<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'createList'])->name('tasks.createList');
Route::put('/tasks/{id}', [TaskController::class, 'updateList'])->name('tasks.updateList');
Route::delete('/tasks', [TaskController::class, 'destroyList'])->name('tasks.destroyList');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::post('/tasks/{id}/add', [TaskController::class, 'createTask'])->name('tasks.createTask');
Route::put('/tasks/{id}', [TaskController::class, 'updateTask'])->name('tasks.updateTask');
Route::delete('/tasks/{id}/delete', [TaskController::class, 'destroyTask'])->name('tasks.destroyTask');


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