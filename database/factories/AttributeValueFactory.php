<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribute_id' => Attribute::inRandomOrder()->value('id'),
            'entity_id' => Project::inRandomOrder()->value('id'),
            'value' => fake()->word(),
        ];
    }

    public function forAttribute(Attribute $attribute): self
    {
        return $this->state(function (array $attributes) use ($attribute) {
            switch ($attribute->type) {
                case 'text':
                    $value = fake()->word;
                    break;

                case 'number':
                    $value = fake()->numberBetween(1, 100);
                    break;

                case 'date':
                    $value = fake()->date;
                    break;

                case 'select':
                    $value = fake()->randomElement(['test1', 'test2', 'test3']);
                    break;

                default:
                    $value = fake()->word();
            }

            return [
                'attribute_id' => $attribute->id,
                'value' => $value,
            ];
        });
    }
}
