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
    $response = $this->actingAs($user)->post('/api/tasks', [
        'name' => 'Test Task',
    ]);

    $response
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

    $response = $this->actingAs($user)->put('/api/tasks/' . $task->id, [
        'name' => 'Updated Task',
    ]);

    $response
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

    $response = $this->actingAs($user)->delete('/api/tasks/' . $task->id);

    $response->assertStatus(204);

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});
