<?php

namespace App\Http\Requests\Profile;

use App\Enums\GenderEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'gender' => ['required', 'string', Rule::enum(GenderEnum::class)],
            'image' => ['nullable', 'image', 'extensions:jpg,png', 'mimes:jpg,png', 'max:512', 'dimensions:width=160,height=160'],
            'delete_image' => ['nullable', 'string'],
        ];
    }
}
