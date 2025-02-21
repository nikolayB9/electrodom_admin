<?php

namespace App\Http\Requests\Order;

use App\Enums\Order\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'status' => ['required', 'integer', Rule::enum(StatusEnum::class)],
            'address' => ['required', 'array:city,street,house,flat'],
            'address.city' => ['required', 'string', 'max:255'],
            'address.*' => ['nullable', 'string', 'max:255'],
        ];
    }
}
