<?php

namespace App\Http\Controllers;

use App\Enums\User\GenderEnum;
use App\Enums\User\OrderByEnum;
use App\Http\Filters\UserFilter;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(IndexRequest $request)
    {
        $filter = app()->make(UserFilter::class, ['queryParams' => array_filter($request->validated())]);
        $users = User::filter($filter)->where('id', '!=', auth()->user()->id)->paginate(15);

        return view('user.index', [
            'users' => $users,
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
