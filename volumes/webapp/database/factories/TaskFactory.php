<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
        $now = now();

        $startDateUpperBoundNumber = fake()->numberBetween(1,10);
        $startDateUpperBound = '+' . $startDateUpperBoundNumber . ' week';

        $endDateLowerBoundNumber = fake()->numberBetween($startDateUpperBoundNumber + 1,50);
        $endDateLowerBound = '+' . $endDateLowerBoundNumber . ' week';

        $endDateUpperBoundNumber = fake()->numberBetween($endDateLowerBoundNumber + 1,$endDateLowerBoundNumber + 50);
        $endDateUpperBound = '+' . $endDateUpperBoundNumber . ' week';

        return [
            'name' => 'The ' . fake()->jobTitle() . ' must make it ' . fake()->colorName() . '.',
            //'uuid' => fake()->uuid(),
            'project_id' => Project::factory(),
            'priority' => fake()->numberBetween(1,10),
            'start_dt' => fake()->dateTimeBetween('now', $startDateUpperBound),
            'end_dt' => fake()->dateTimeBetween($endDateLowerBound, $endDateUpperBound),
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ];
    }
}
