<?php

namespace Database\Factories;

use App\Models\MeasureUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->unique()->words(rand(1, 2), true)),
            'measure_unit_id' => rand(0,1) ? null : MeasureUnit::factory()->create(),
        ];
    }
}
