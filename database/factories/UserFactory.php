<?php

namespace Database\Factories;

use App\Enums\User\GenderEnum;
use App\Enums\User\RoleEnum;
use App\Models\Address;
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
            'phone_number' => fake()->unique()->regexify('(8|\+7)9[0-9]{9}'),
            'gender' => fake()->randomElement(GenderEnum::class),
            'role' => RoleEnum::USER,
            'address_id' => rand(0,1) ? Address::factory()->create() : null,
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
