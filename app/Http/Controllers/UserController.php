<?php

namespace App\Http\Controllers;

use App\Enums\User\GenderEnum;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
           'users' => User::all()->except([auth()->user()->id]),
        ]);
    }

    public function edit(User $user, ProfileService $profileService): View
    {
        return view('user.edit', [
            'user' => $user,
            'imgParams' => $profileService::getImgParams(),
            'genders' => GenderEnum::getValues(),
        ]);
    }

    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return Redirect::route('users.edit', $user->id)->with('status', 'Данные пользователя обновлены.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::route('users.index')->with('status', 'Пользователь "' . $user->name . '" удален.');
    }
}
