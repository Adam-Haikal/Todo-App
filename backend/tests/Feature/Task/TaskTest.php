<?php

use App\Models\Task;
use App\Models\User;

test('users can view tasks created by them only', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->get('/api/tasks')
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'id' => $task->id,
            'name' => $task->name,
        ])
        ->assertStatus(200);
});

test('users can create tasks', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/api/tasks', [
            'name' => 'Test Task',
        ])
        ->assertJsonFragment([
            'name' => 'Test Task',
            'user_id' => $user->id,
        ])
        ->assertStatus(201);

    $this->assertDatabaseHas('tasks', [
        'name' => 'Test Task',
    ]);
});

test('users can update tasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->put('/api/tasks/' . $task->id, [
            'name' => 'Updated Task',
        ])
        ->assertJsonFragment([
            'name' => 'Updated Task',
        ])
        ->assertStatus(200);

    $this->assertDatabaseHas('tasks', [
        'name' => 'Updated Task',
    ]);
});

test('users can delete tasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->delete('/api/tasks/' . $task->id)
        ->assertStatus(204);

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});
