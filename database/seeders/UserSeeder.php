<?php

namespace Database\Seeders;

use App\Enums\User\GenderEnum;
use App\Enums\User\RoleEnum;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = [
            'name' => 'Админ',
            'surname' => 'Админов',
            'patronymic' => 'Админович',
            'gender' => GenderEnum::Male,
            'role' => RoleEnum::Admin,
            'email' => 'admin@mail.ru',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123'),
        ];

        User::insert($admin);

        User::factory(10)
            ->create();

        User::factory(10)
            ->has(Address::factory())
            ->create();
    }
}
