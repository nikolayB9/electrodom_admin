<?php

namespace App\Http\Requests\API\V1\Product;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'categoryId' => 'nullable|integer|exists:categories,id',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|array',
            'priceMin' => 'nullable|integer',
            'priceMax' => 'nullable|integer',
            'orderBy' => 'nullable|string',
            'showBy' => 'nullable|integer',
            'page' => 'nullable|integer',
        ];
    }
}
