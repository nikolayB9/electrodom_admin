<?php

namespace App\Http\Requests\Auth;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'regex:/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', 'unique:users,phone_number'],
            'gender' => ['nullable', 'string', Rule::enum(GenderEnum::class)],
            'image' => ['nullable', 'image', 'extensions:jpg,png', 'mimes:jpg,png', 'max:512', 'dimensions:width=160,height=160'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
