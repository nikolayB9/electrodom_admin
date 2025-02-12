<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Order\StoreRequest;
use App\Http\Requests\API\V1\Order\SumPriceRequest;
use App\Models\User;
use App\Services\API\V1\OrderService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $cartPrice = $this->orderService->getCartPrice($data['products']);
        $totalPrice = $this->orderService->getTotalPrice($cartPrice, $data['coupon'], $data['shipping']);

        if ($cartPrice !== $data['cartPrice'] || $totalPrice !== $data['totalPrice']) {
            return response()->json('Error');
        }

        if (!$request->user()) {
            $temporaryPassword = Str::random(8);
            $userData = [
                'name' => $data['name'],
                'surname' => $data['surname'],
                'patronymic' => $data['patronymic'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'password' => $temporaryPassword,
            ];
            $user = User::create($userData);
            event(new Registered($user));
            Auth::login($user);
        } else {
            $user = $request->user();
        }

        $addressData = [
          'city' => $data['city'],
          'street' => $data['street'],
          'house' => $data['house'],
          'flat' => $data['flat'],
        ];

        $address = $this->orderService->processAddress($user, $addressData);

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
