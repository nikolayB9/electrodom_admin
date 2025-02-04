<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\User\GenderEnum;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function getGenders(): \Illuminate\Http\JsonResponse
    {
        return response()->json(GenderEnum::cases());
    }

    public function register(RegisterRequest $request): true
    {
        $data = $request->validated();

        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);

        return true;
    }
}
