<?php

namespace App\Services\API\V1;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;

class OrderService
{
    public function getCartPrice(array $products): float
    {
        $cartPrice = 0;
        foreach ($products as $product) {
            $price = Product::whereId($product['id'])->value('price');
            $cartPrice += round($price * $product['qty'], 2);
        }
        return $cartPrice;
    }

    public function getTotalPrice(float $cartPrice, ?float $coupon, ?float $shipping): float
    {
        return round($cartPrice - $coupon + $shipping, 2);
    }

    public function getDecimalFormat(float|int $number): string
    {
        return number_format($number, 2, '.', '');
    }

    public function processAddress(User $user, array $addressData): Address
    {
        $currentUserAddress = $user->address;

        if ($currentUserAddress && $currentUserAddress->canBeDeleted()) {
            $currentUserAddress->update($addressData);
        } elseif ($addressData['city'] || $addressData['street'] || $addressData['house'] || $addressData['flat']) {
            $newAddress = Address::create($addressData);
            $user->update(['address_id' => $newAddress->id]);
            return $newAddress;
        }
        return $currentUserAddress;
    }
}
