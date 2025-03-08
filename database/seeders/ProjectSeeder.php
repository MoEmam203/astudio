<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
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
        $attributes = Attribute::get();
        Project::factory()
            ->count(10)
            ->create()
            ->each(function ($project) use ($attributes) {
                $project->users()->attach(User::all()->random(5)->pluck('id'));

                foreach ($attributes as $attribute) {
                    AttributeValue::factory()
                        ->forAttribute($attribute)
                        ->create([
                            'attribute_id' => $attribute->id,
                            'entity_id' => $project->id,
                        ]);
                }
            });
    }
}
