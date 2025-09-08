<?php

namespace App\Http\Requests;

use App\Models\PersonalDataType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalDataTypeRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        /** @var PersonalDataType $dataType */
        $dataType = $this->route('personal_data_type');

        return [
            'data_type' => [
                'required',
                'string',
                Rule::unique(PersonalDataType::class, 'data_type')
                    ->ignore(optional($dataType)->id),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
