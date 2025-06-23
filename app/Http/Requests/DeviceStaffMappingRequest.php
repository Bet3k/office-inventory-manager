<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;

class DeviceStaffMappingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<ValidationRule|Unique|In|string>|ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'member_of_staff_id' => ['required', 'exists:member_of_staff,id'],
            'device_id' => [
                'required',
                'exists:devices,id',
                Rule::unique('device_staff_mappings', 'device_id')->where(function ($query) {
                    return $query->where('member_of_staff_id', $this->input('member_of_staff_id'));
                }),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
