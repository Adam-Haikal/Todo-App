<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;

Route::prefix("lists")->group(function () {
    Route::get('/', [ListController::class, 'index'])->name('lists.index');
    Route::post('/', [ListController::class, 'create'])->name('lists.create');
    Route::put('/{id}', [ListController::class, 'update'])->name('lists.update');
    Route::delete('/', [ListController::class, 'destroy'])->name('lists.destroy');
});

Route::prefix("tasks")->group(function () {
    Route::get('/{id}', [TaskController::class, 'index'])->name('tasks.index'); // Show a specific list with its tasks
    Route::post('/{id}', [TaskController::class, 'create'])->name('tasks.create');
    Route::put('/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
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