<?php

namespace App\Http\Requests\User;

use App\Enums\User\GenderEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'patronymic' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->route('user')),
            ],
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7}$/',
                Rule::unique(User::class)->ignore($this->route('user')),
            ],
            'gender' => ['required', 'string', Rule::enum(GenderEnum::class)],
            'address' => ['array:city,street,house,flat'],
            'address.*' => ['nullable', 'string', 'max:255'],
        ];
    }
}
