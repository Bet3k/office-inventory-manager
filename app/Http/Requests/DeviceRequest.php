<?php

namespace App\Http\Requests;

use App\Models\Device;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;

class DeviceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<ValidationRule|Unique|In|string>|ValidationRule|string>
     */
    public function rules(): array
    {
        /** @var Device $device */
        $device = $this->route('device');

        return [
            'brand' => ['required', 'string'],
            'type' => ['required', 'string'],
            'serial_number' => [
                'required',
                'string',
                Rule::unique('devices', 'serial_number')->ignore($device->id),
            ],
            'status' => ['required', 'string'],
            'service_status' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
