<?php

namespace App\Http\Requests\Product;

use App\Enums\Product\OrderByEnum;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => ['nullable', 'string', 'max:255'],
            'categoryId' => ['nullable', 'integer', 'exists:categories,id'],
            'orderBy' => ['nullable', Rule::enum(OrderByEnum::class)],
        ];
    }

    protected function passedValidation(): void
    {
        if ($this->categoryId) {
            $this->merge(['categories' => Category::find($this->categoryId)->getIdsIncludingChildCategories()]);
        }
    }
}
