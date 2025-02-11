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
            $currentAddress->update($this->getAddressFields($address));
        } elseif ($address['city'] || $address['street'] || $address['house'] || $address['flat']) {
            $newAddress = Address::create($this->getAddressFields($address));
            $data['address_id'] = $newAddress->id;
        }

        unset($data['address']);
        return $data;
    }

    private function getAddressFields(array $address): array
    {
        return [
            'city' => $address['city'],
            'street' => $address['street'],
            'house' => $address['house'],
            'flat' => $address['flat'],
        ];
    }
}
