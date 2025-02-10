<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->unique()->words(rand(3, 10), true)),
            'description' => fake()->randomElement([null, fake()->sentences(rand(1, 6), true)]),
            'image' => null,
            'count' => fake()->randomNumber(3),
            'price' => fake()->randomFloat(2, 0.1, 10000),
            'old_price' => fake()->randomElement([null, fake()->randomFloat(2, 100, 15000)]),
            'is_published' => 1,
        ];
    }
}
