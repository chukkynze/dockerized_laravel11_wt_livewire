<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = now();
        $typeName = [
            1 => 'App',
            2 => 'Saas',
            3 => 'DevOps',
        ];
        $statusId = fake()->numberBetween(1,3);

        return [
            'name' => fake()->company() . ' ' . $typeName[$statusId] . ' Project',
            'type_id' => fake()->numberBetween(1,3),
            'status_id' => $statusId,
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ];
    }
}
