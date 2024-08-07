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

        $dueByDateLowerBoundNumber = fake()->numberBetween($startDateUpperBoundNumber + 1,50);
        $dueByDateLowerBound = '+' . $dueByDateLowerBoundNumber . ' week';

        $dueByDateUpperBoundNumber = fake()->numberBetween($dueByDateLowerBoundNumber + 1,$dueByDateLowerBoundNumber + 50);
        $dueByDateUpperBound = '+' . $dueByDateUpperBoundNumber . ' week';

        return [
            'name' => 'The ' . fake()->jobTitle() . ' must make it ' . fake()->colorName() . '.',
            'project_id' => Project::factory(),
            'priority' => fake()->numberBetween(1,10),
            'start_dt' => fake()->dateTimeBetween('now', $startDateUpperBound),
            'due_by_dt' => fake()->dateTimeBetween($dueByDateLowerBound, $dueByDateUpperBound),
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ];
    }
}
