<?php

namespace App\Http\Requests\Product;

use App\Validation\Product\CheckingAttributesOfTheProduct;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributesRequest extends FormRequest
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
            'attributes_ids' => ['array'],
            'attributes_ids.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Checking for all product attributes in the resulting array.
     */
    public function after(): array
    {
        return [
            new CheckingAttributesOfTheProduct(),
        ];
    }
}
