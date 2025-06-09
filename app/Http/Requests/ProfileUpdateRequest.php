<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Unique;

class ProfileUpdateRequest extends FormRequest
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
     * @return array<string, array<ValidationRule|Unique|In|string>|ValidationRule|string>
     */

    public function rules(): array
    {
        /** @var User $user */
        $user = $this->user();

        return [
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'gender' => ['nullable', Rule::in(GenderEnum::getValues())],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'date_of_birth' => ['nullable','date','date_format:Y-m-d'],
        ];
    }
}
