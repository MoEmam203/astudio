<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory()
            ->count(10)
            ->create()
            ->each(function ($project) {
                $project->users()->attach(User::all()->random(5)->pluck('id'));
            });
    }
}
