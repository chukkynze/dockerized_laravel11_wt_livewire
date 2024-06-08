<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i=0; $i < fake()->numberBetween(100, 1000); $i++)
        {
            Project::factory(3)
                ->has(Task::factory()->count(rand(1,15)))
                ->create();
        }
    }
}
