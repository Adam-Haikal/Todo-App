<?php

use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;

test('users can view subtasks created by them only', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $subtask = Subtask::factory()->create(['task_id' => $task->id]);

    $this->actingAs($user)
        ->get('/api/subtasks?task_id=' . $subtask->id)
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'id' => $subtask->id,
            'name' => $subtask->name,
            'completed' => $subtask->completed,
        ])
        ->assertStatus(200);
});

test('users can create subtasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->post('/api/subtasks', [
            'name' => 'Test Subtask',
            'task_id' => $task->id,
            'completed' => false,
        ])
        ->assertJsonFragment([
            'task_id' => $task->id,
            'name' => 'Test Subtask',
            'completed' => false,
        ])
        ->assertStatus(201);

    $this->assertDatabaseHas('subtasks', [
        'name' => 'Test Subtask',
    ]);
});

test('users can update subtasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $subtask = Subtask::factory()->create(['task_id' => $task->id]);

    $this->actingAs($user)
        ->put('/api/subtasks/' . $subtask->id, [
            'name' => 'Updated Subtask',
            'completed' => true,
        ])
        ->assertJsonFragment([
            'name' => 'Updated Subtask',
            'completed' => true,
        ])
        ->assertStatus(200);

    $this->assertDatabaseHas('subtasks', [
        'name' => 'Updated Subtask',
        'completed' => true,
    ]);
});

test('users can delete subtasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $subtask = Subtask::factory()->create(['task_id' => $task->id]);

    $this->actingAs($user)
        ->delete('/api/subtasks/' . $subtask->id)
        ->assertStatus(204);

    $this->assertDatabaseMissing('subtasks', [
        'id' => $subtask->id,
    ]);
});
