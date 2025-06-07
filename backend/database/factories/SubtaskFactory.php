<?php

namespace Database\Factories;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subtask>
 */
class SubtaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Subtask::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'task_id' => Task::factory()->create()->id,
            'completed' => fake()->boolean(),
            'completed_at' => now(),
        ];
    }
}
