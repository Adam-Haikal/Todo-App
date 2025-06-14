<?php

namespace Database\Seeders;

use App\Models\Tags;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* create 10 tags with different colors and corresponding user_id */
        $user = User::factory()->create();

        /* Create 10 tags without a user */
        Tags::factory()->count(10)->create();

        /* Create 10 tags with the same user */
        Tags::factory()->forUser($user)->count(10)->create();
    }
}
