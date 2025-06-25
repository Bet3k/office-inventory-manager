<?php

namespace App\Http\Requests;

use App\Models\Software;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;

class SoftwareRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<ValidationRule|Unique|In|string>|ValidationRule|string>
     */
    public function rules(): array
    {
        /** @var Software|null $software */
        $software = $this->route('software');

        return [
            'name' => ['required',
                $software
                    ? Rule::unique('software', 'name')->ignore($software->id)
                    : Rule::unique('software', 'name'),
            ],
            'status' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
