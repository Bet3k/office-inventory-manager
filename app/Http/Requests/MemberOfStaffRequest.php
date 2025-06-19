<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;

class MemberOfStaffRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<ValidationRule|Unique|In|string>|ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:3', 'max:50'],
            'last_name' => ['required', 'min:3', 'max:50'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
