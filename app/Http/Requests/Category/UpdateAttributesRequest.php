<?php

namespace App\Http\Requests\Category;

use App\Validation\CheckingAttributesOfTheParentCategory;
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
            'attributes_ids' => ['nullable', 'array'],
            'attributes_ids.*' => ['nullable', 'integer', 'distinct', 'exists:attributes,id'],
        ];
    }

    public function after(): array
    {
        return [
            new CheckingAttributesOfTheParentCategory(),
        ];
    }
}
