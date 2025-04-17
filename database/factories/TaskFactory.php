<?php

namespace Database\Factories;

use App\Models\ListTask;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_name'=> fake()->sentence(2),
            'list_task_id' => ListTask::factory(),
            'description' => fake()->sentence(3),
            'is_completed' => fake()->boolean()
        ];
    }
}
