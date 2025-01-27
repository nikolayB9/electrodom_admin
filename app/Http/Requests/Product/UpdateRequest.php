<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
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
        $imgParams = ProductService::getImgParams();
        $categoryService = new CategoryService();
        $lastLevelCategoryIds = $categoryService->getLastNestingLevelCategories()->pluck('id')->toArray();

        return [
            'title' => ['required', 'string', 'max:255',  Rule::unique(Product::class)->ignore(request()->product)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'decimal:0,2', 'gte:0'],
            'old_price' => ['nullable', 'decimal:0,2', 'gte:0'],
            'count' => ['required', 'integer', 'gte:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id', Rule::in($lastLevelCategoryIds)],
            'image' => [
                'nullable',
                'image',
                "extensions:{$imgParams['extensions']}",
                "mimes:{$imgParams['mimes']}",
                "max:{$imgParams['maximum_size']}",
                "dimensions:width={$imgParams['width']},height={$imgParams['height']}",
            ],
            'delete_image' => ['nullable', 'string', 'in:on'],
            'is_published' => ['nullable', 'string', 'in:on'],
        ];
    }
}
