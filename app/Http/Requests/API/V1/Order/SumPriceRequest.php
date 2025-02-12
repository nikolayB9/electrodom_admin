<?php

namespace App\Http\Requests\API\V1\Order;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SumPriceRequest extends FormRequest
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
            'products' => ['array'],
            'products.*' => ['array:id,qty'],
            'products.*.id' => ['integer', 'exists:products,id'],
            'products.*.qty' => ['integer'],
            'coupon' => ['nullable', 'decimal:0,2'],
            'shipping' => ['nullable', 'decimal:0,2'],
        ];
    }
}
