<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function processAddress(User $user, array $data): array
    {
        $address = $data['address'];

        if ($user->address || $address['city'] || $address['street'] || $address['house'] || $address['flat']) {
            $user->address()->updateOrCreate(['user_id' => $user->id],
                [
                    'city' => $address['city'],
                    'street' => $address['street'],
                    'house' => $address['house'],
                    'flat' => $address['flat'],
                ]);
        }

        unset($data['address']);
        return $data;
    }
}
