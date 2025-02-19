<?php

namespace App\Http\Controllers;

use App\Enums\Order\StatusEnum;
use App\Http\Filters\OrderFilter;
use App\Http\Requests\Order\IndexRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(OrderFilter::class, ['queryParams' => array_filter($data)]);
        $orders = Order::filter($filter);

        return view('order.index', [
            'orders' => $orders->with('user')->paginate(15),
        ]);
    }

    public function edit(Order $order)
    {
        return view('order.edit', [
            'order' => $order,
            'statuses' => StatusEnum::asSelectArray(),
            'address' => $order->address,
        ]);
    }

    public function update(UpdateRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->update([
            'status' => $data['status'],
        ]);
        $order->address()->update($data['address']);

        return redirect()->route('orders.edit', $order->id)->with('status', 'Данные заказа обновлены.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('status', 'Заказ № "' . $order->id . '" удален.');
    }

    public function restore(int $orderId)
    {
        Order::withTrashed()->find($orderId)->restore();
        return redirect()->route('orders.edit', $orderId)->with('status', 'Заказ восстановлен.');
    }
}
