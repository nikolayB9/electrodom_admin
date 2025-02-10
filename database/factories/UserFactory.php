<?php

namespace Database\Factories;

use App\Enums\User\GenderEnum;
use App\Enums\User\RoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->randomElement([null, fake()->lastName]),
            'patronymic' => fake()->randomElement([null, ucfirst(fake()->word)]),
            'email' => fake()->unique()->safeEmail(),
            'gender' => fake()->randomElement(GenderEnum::class),
            'role' => RoleEnum::User,
            'email_verified_at' => now(),
            'password' => Hash::make('123123123'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
