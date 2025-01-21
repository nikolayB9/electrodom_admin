<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
        return [
            'title' => ['required', 'string', 'max:255'],
            'measure_unit_id' => ['nullable', 'integer', 'exists:measure_units,id', 'prohibits:new_measure_unit'],
            'new_measure_unit' => ['nullable', 'string', 'max:255', 'unique:measure_units,title'],
        ];
    }

    /**
     * If the attribute's title is not unique, then the attribute's units of measurement must differ.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $validated = $validator->validated();
                if (empty($validated['new_measure_unit'])) {
                    request()->validate([
                        'title' => Rule::unique('attributes', 'title')
                            ->where(fn(Builder $query) => $query->where('measure_unit_id', $validated['measure_unit_id']))
                    ]);
                }
            }
        ];
    }
}
