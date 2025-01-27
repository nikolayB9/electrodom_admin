<?php

namespace App\Http\Controllers\Auth;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\UserImage;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct(public ProfileService $profileService)
    {
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {

        return view('auth.register', [
            'genders' => GenderEnum::getValues(),
            'imgParams' => $this->profileService::getImgParams(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['role'] = RoleEnum::Admin;

        $user = $this->profileService->createUser($data);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('index', absolute: false));
    }
}
