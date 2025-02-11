<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Order\StoreRequest;

class OrderController extends Controller
{
    public function store(StoreRequest $request)
    {
        return $request->validated();
    }
}
