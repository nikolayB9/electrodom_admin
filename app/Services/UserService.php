<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;

class UserService
{
    public function processAddress(User $user, array $data): array
    {
        $address = $data['address'];
        $currentAddress = $user->address;

        if ($currentAddress && $currentAddress->canBeDeleted()) {
            $currentAddress->update($address);
        } elseif ($address['city'] || $address['street'] || $address['house'] || $address['flat']) {
            $newAddress = Address::create($address);
            $data['address_id'] = $newAddress->id;
        }

        unset($data['address']);
        return $data;
    }
}
