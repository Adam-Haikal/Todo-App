<?php

use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('tasks', TaskController::class)->only('index', 'store', 'update', 'destroy', 'show');
    Route::apiResource('subtasks', SubtaskController::class)->only('index', 'store', 'update', 'destroy');
    Route::apiResource('tags', TagController::class)->only('index', 'store', 'update', 'destroy');
});
