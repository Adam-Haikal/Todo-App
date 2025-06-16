<?php

namespace Database\Factories;

use App\Models\Tags;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tags>
 */
class TagsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tags::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'color' => fake()->hexColor(),
            'task_id' => null,
            'user_id' => null,
            // 'user_id' => User::factory()->create()->id,
        ];
    }

    public function forUser(User $user)
    {
        return $this->state(['user_id' => $user->id]);
    }

    public function forTask(Tags $task)
    {
        return $this->state(['task_id' => $task->id]);
    }
}
