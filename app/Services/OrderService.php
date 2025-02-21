<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Order;

class OrderService
{
    public function processAddress(Order $order, array $data): Address
    {
        $address = $order->address;

        if (!$this->isChanged($address, $data)) {
            return $address;
        }

        if ($address->canBeChangedInTheOrder($order)) {
            $address->update($data);
            return $address;
        }

        return Address::create($data);
    }

    private function isChanged(Address $address, array $data): bool
    {
        foreach ($data as $item => $value) {
            if ($address[$item] != $value) {
                return true;
            }
        }
        return false;
    }
}
