<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        /** @var Department $department */
        $department = $this->route('department');

        return [
            'department' => [
                'required',
                'string',
                Rule::unique(Department::class, 'department')
                    ->ignore(optional($department)->id),
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
