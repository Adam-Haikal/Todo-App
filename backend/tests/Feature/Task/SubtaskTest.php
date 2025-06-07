<?php

use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;

test('subtasks are associated with tasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $subtask = Subtask::factory()->create(['task_id' => $task->id]);

    $response = $this->actingAs($user)
        ->get('/api/subtasks/' . $task->id)
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'id' => $subtask->id,
            'name' => $subtask->name,
        ])
        ->assertStatus(200);
});

test('users can view subtasks created by them only', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $subtask = Subtask::factory()->create(['task_id' => $task->id]);

    $response = $this->actingAs($user)
        ->get('/api/subtasks/' . $task->id)
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'id' => $subtask->id,
            'name' => $subtask->name,
            'completed' => $subtask->completed,
            'completed_at' => $subtask->completed_at,
        ])
        ->assertStatus(200);
});

test('users can create subtasks', function () {});

test('users can update subtasks', function () {});

test('users can delete subtasks', function () {});
