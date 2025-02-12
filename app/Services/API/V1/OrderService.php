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
            $price = $this->getProductPriceById($product['id']);
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

    public function processAddress(User $user, array $data): Address
    {
        $addressData = [
            'city' => $data['city'],
            'street' => $data['street'],
            'house' => $data['house'],
            'flat' => $data['flat'],
        ];

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

    public function processProductsForPivot(array $products): array
    {
        $dataPivot = [];
        foreach ($products as $product) {
            $productId = $product['id'];
            $price = $this->getProductPriceById($productId);
            $dataPivot[$productId] = [
                'price' => $price,
                'qty' => $product['qty'],
                'total_price' => round($price * $product['qty'], 2),
            ];
        }
        return $dataPivot;
    }

    private function getProductPriceById(int $productId): float
    {
        return Product::whereId($productId)->value('price');
    }
}
