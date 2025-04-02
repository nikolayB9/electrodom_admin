<?php

namespace App\Http\Requests\Attribute;

use App\Models\Attribute;
use App\Models\MeasureUnit;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
        return [
            'updatedMeasureUnitId' => ['nullable', 'integer', 'exists:measure_units,id', 'prohibits:updatedNewMeasureUnit'],
            'updatedNewMeasureUnit' => ['nullable', 'string', 'max:255', 'unique:measure_units,title'],
            'updatedTitle' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (empty($this->updatedNewMeasureUnit)) {
                        if (Attribute::where('title', $value)
                            ->where('measure_unit_id', $this->updatedMeasureUnitId)
                            ->whereNot('id', $this->attribute->id)
                            ->first()) {
                            $fail("The {$attribute} has already been taken.");
                        }
                    }
                },
            ],
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $validator->errors()->add('attributeIdError', $this->attribute->id);
        throw new ValidationException($validator, back()->withErrors($validator->errors())->withInput());
    }

    protected function passedValidation(): void
    {
        if (!empty($this->updatedMeasureUnitId)) {
            $id = $this->updatedMeasureUnitId;
        } elseif (!empty($this->updatedNewMeasureUnit)) {
            $id = MeasureUnit::create([
                'title' => $this->updatedNewMeasureUnit,
            ])->id;
        } else {
            $id = null;
        }

        $this->replace([
            'title' => $this->updatedTitle,
            'measure_unit_id' => $id,
        ]);
    }
}
