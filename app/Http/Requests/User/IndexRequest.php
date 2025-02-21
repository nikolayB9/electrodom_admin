<?php

namespace App\Http\Requests\User;

use App\Enums\User\OrderByEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nameOrEmail' => ['nullable', 'string', 'max:255'],
            'orderBy' => ['nullable', Rule::enum(OrderByEnum::class)],
            'trashed' => ['nullable', 'boolean:true'],
        ];
    }


}
