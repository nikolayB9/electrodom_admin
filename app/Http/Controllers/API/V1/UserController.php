<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\User\GenderEnum;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function show(Request $request)
    {
        return UserResource::make($request->user());
    }

    public function register(RegisterRequest $request): \Illuminate\Http\Response
    {
        $user = User::create($request->validated());

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }

    public function login(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    public function logout(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }

    public function getGenders(): \Illuminate\Http\JsonResponse
    {
        return response()->json(GenderEnum::cases());
    }
}
