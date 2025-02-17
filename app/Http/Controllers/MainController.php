<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class MainController extends Controller
{
    public function index(): View
    {
        return view('main.index', [
            'numberOfOrders' => Order::count(),
            'numberOfProducts' => Product::count(),
            'numberOfUsers' => User::count(),
        ]);
    }
}
