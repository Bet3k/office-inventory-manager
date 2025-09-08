<?php

namespace App\Http\Requests;

use App\Models\PersonalDataProcessed;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PersonalDataProcessedRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        /** @var PersonalDataProcessed $processedData */
        $processedData = $this->route('personal_data_processed');

        return [
            'name' => [
                'required',
                'string',
                Rule::unique(PersonalDataProcessed::class, 'name')
                    ->ignore(optional($processedData)->id),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
