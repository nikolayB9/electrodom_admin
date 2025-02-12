<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Order\StoreRequest;
use App\Http\Requests\API\V1\Order\SumPriceRequest;
use App\Models\Order;
use App\Services\API\V1\OrderService;
use App\Services\API\V1\UserService;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function store(StoreRequest $request, UserService $userService)
    {
        $data = $request->validated();

        $cartPrice = $this->orderService->getCartPrice($data['products']);
        $totalPrice = $this->orderService->getTotalPrice($cartPrice, $data['coupon'], $data['shipping']);

        if (!auth()->user()) {
            $user = $userService->createFromOrder($data);
        } else {
            $user = auth()->user();
        }

        $address = $this->orderService->processAddress($user, $data);

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'cart_price' => $cartPrice,
            'total_price' => $totalPrice,
            'coupon' => $data['coupon'],
            'shipping' => $data['shipping'],
        ]);

        $dataPivot = $this->orderService->processProductsForPivot($data['products']);
        $order->products()->attach($dataPivot);

        return response()->noContent();
    }

    public function getSumPrice(SumPriceRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $coupon = $data['coupon'] ?? null;
        $shipping = $data['shipping'] ?? null;

        $cartPrice = $this->orderService->getCartPrice($data['products']);
        $totalPrice = $this->orderService->getTotalPrice($cartPrice, $coupon, $shipping);

        return response()->json([
            'cartPrice' => $this->orderService->getDecimalFormat($cartPrice),
            'totalPrice' => $this->orderService->getDecimalFormat($totalPrice),
        ]);
    }
}
