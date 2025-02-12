<?php

namespace App\Http\Requests\API\V1\Order;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $user = $this->user() ?? null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['present', 'nullable', 'string', 'max:255'],
            'patronymic' => ['present', 'nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user),
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7}$/',
                Rule::unique(User::class)->ignore($user),
            ],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['present', 'nullable', 'string', 'max:255'],
            'house' => ['present', 'nullable', 'string', 'max:255'],
            'flat' => ['present', 'nullable', 'string', 'max:255'],
            'comment' => ['present', 'nullable', 'string', 'max:255'],
            'products' => ['array'],
            'products.*' => ['array:id,qty'],
            'products.*.id' => ['integer', 'exists:products,id'],
            'products.*.qty' => ['integer'],
            'coupon' => ['present', 'nullable', 'decimal:0,2'],
            'shipping' => ['present', 'nullable', 'decimal:0,2'],
            'cart_price' => ['decimal:0,2'],
            'total_price' => ['decimal:0,2'],
        ];
    }
}
