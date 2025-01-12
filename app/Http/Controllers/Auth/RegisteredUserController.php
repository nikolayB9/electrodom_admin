<?php

namespace App\Http\Controllers\Auth;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\UserImage;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', ['genders' => GenderEnum::getValues()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['image'])) {
            $image_path = Storage::disk('public')->put('/images', $data['image']);
            unset($data['image']);
        }

        $data['role'] = RoleEnum::Admin;

        $user = User::create($data);

        if (!empty($image_path)) {
            UserImage::create([
               'image_path' => $image_path,
               'user_id' => $user->id,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('index', absolute: false));
    }
}
