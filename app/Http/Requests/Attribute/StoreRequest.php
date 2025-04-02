<?php

namespace App\Http\Requests\Attribute;

use App\Models\Attribute;
use App\Models\MeasureUnit;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

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
            'measureUnitId' => ['nullable', 'integer', 'exists:measure_units,id', 'prohibits:newMeasureUnit'],
            'newMeasureUnit' => ['nullable', 'string', 'max:255', 'unique:measure_units,title'],
            'title' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (empty($this->newMeasureUnit)) {
                        if (Attribute::where('title', $value)
                            ->where('measure_unit_id', $this->measureUnitId)
                            ->first()) {
                            $fail("The {$attribute} has already been taken.");
                        }
                    }
                },
            ],
        ];
    }

    protected function passedValidation(): void
    {
        if (!empty($this->measureUnitId)) {
            $id = $this->measureUnitId;
        } elseif (!empty($this->newMeasureUnit)) {
            $id = MeasureUnit::create([
                'title' => $this->newMeasureUnit,
            ])->id;
        } else {
            $id = null;
        }

        $this->replace([
            'title' => $this->title,
            'measure_unit_id' => $id,
        ]);
    }
}
