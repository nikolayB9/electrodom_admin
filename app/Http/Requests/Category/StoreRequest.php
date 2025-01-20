<?php

namespace App\Http\Requests\Category;

use App\Validation\CheckingParentCategoryLevel;
use App\Validation\CheckingPreviousAndParentCategoryHierarchy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

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
        $imgParams = config('images.category');

        return [
            'title' => ['required', 'string', 'max:255', 'unique:categories,title'],
            'parent_category' => ['nullable', 'integer', 'exists:categories,id'],
            'previous_category' => ['nullable', 'integer', 'exists:categories,id'],
            'image' => [
                'nullable',
                'image',
                "extensions:{$imgParams['extensions']}",
                "mimes:{$imgParams['mimes']}",
                "max:{$imgParams['maximum_size']}",
                "dimensions:width={$imgParams['width']},height={$imgParams['height']}",
            ],
        ];
    }

    /**
     * If the parent category is passed, we check that it can have descendants.
     * If the previous category is passed, we check that it is a descendant of the parent category.
     */
    public function after(): array
    {
        return [
            new CheckingParentCategoryLevel(),
            new CheckingPreviousAndParentCategoryHierarchy(),
        ];
    }
}
