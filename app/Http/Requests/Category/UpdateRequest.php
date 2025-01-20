<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use App\Validation\CheckingNewParentCategoryLevel;
use App\Validation\CheckingPreviousAndParentCategoryHierarchy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
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
        $imgParams = config('images.category');

        return [
            'title' => ['required', 'string', 'max:255',  Rule::unique(Category::class)->ignore(request()->category)],
            'parent_category' => ['nullable', 'integer', 'exists:categories,id', Rule::notIn(request()->category->id)],
            'previous_category' => ['nullable', 'integer', 'exists:categories,id', Rule::notIn(request()->category->id)],
            'image' => [
                'nullable',
                'image',
                "extensions:{$imgParams['extensions']}",
                "mimes:{$imgParams['mimes']}",
                "max:{$imgParams['maximum_size']}",
                "dimensions:width={$imgParams['width']},height={$imgParams['height']}",
            ],
            'delete_image' => ['nullable', 'string'],
        ];
    }

    /**
     * If the parent category is passed, we check that it can have descendants.
     * If the previous category is passed, we check that it is a descendant of the parent category.
     */
    public function after(): array
    {
        return [
            new CheckingNewParentCategoryLevel(),
            new CheckingPreviousAndParentCategoryHierarchy(),
        ];
    }
}
