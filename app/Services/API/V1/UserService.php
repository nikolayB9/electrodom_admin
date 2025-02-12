<?php

namespace App\Services\API\V1;

use App\Models\User;
use Illuminate\Support\Str;

class UserService
{
    public function createFromOrder(array $data): User
    {
        $temporaryPassword = Str::random(8);

        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => $temporaryPassword,
        ]);
    }
}
