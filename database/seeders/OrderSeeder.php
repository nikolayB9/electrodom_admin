<?php

namespace Database\Seeders;

use App\Enums\User\RoleEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    private int $maxRandomOrdersOfUser = 3;
    private int $maxRandomProductsQty = 4;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $allProducts = Product::select('id', 'price')->get();

        foreach ($this->getUsers() as $user) {
            $numberOfOrders = rand(0, $this->maxRandomOrdersOfUser);
            while ($numberOfOrders > 0) {
                $this->createOrder($user, $allProducts);
                $numberOfOrders--;
            }
        }
    }

    private function getUsers(): Collection
    {
        return User::whereNotNull('address_id')
            ->where('role', RoleEnum::USER->value)
            ->select('id', 'address_id')->get();
    }

    private function createOrder(User $user, Collection $allProducts): void
    {
        $product = $allProducts->random();
        $qty = rand(1, $this->maxRandomProductsQty);
        $totalPrice = round($product->price * $qty, 2);
        $coupon = fake()->randomFloat(2, 0, 500);
        $shipping = fake()->randomFloat(2, 0, 1000);

        Order::factory()
            ->hasAttached($product, [
                'price' => $product->price,
                'qty' => $qty,
                'total_price' => $totalPrice,
            ])
            ->create([
                'user_id' => $user->id,
                'address_id' => $user->address_id,
                'cart_price' => $totalPrice,
                'coupon' => $coupon,
                'shipping' => $shipping,
                'total_price' => $totalPrice - $coupon + $shipping,
            ]);
    }
}
