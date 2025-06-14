<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('tasks', TaskController::class)->only('index', 'store', 'update', 'destroy', 'show');
    Route::apiResource('subtasks', SubtaskController::class)->only('index', 'store', 'update', 'destroy');
    Route::apiResource('tags', TagsController::class)->only('index');
});
