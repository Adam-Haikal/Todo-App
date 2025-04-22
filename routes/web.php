<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::delete('/tasks', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks/{id}/add', [TaskController::class, 'addTask'])->name('tasks.addTask');
Route::delete('/tasks/{id}/delete', [TaskController::class, 'deleteTask'])->name('tasks.deleteTask');


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