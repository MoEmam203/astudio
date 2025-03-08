<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSheet>
 */
class TimeSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'project_id' => Project::inRandomOrder()->value('id'),
            'task_name' => fake()->word(),
            'date' => fake()->date(),
            'hours' => fake()->numberBetween(1, 8),
        ];
    }
}
