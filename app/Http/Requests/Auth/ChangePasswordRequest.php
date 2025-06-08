<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
     * @return array<string, array<int, ValidationRule|string>|ValidationRule|string>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var ValidationRule $passwordRule */
        $passwordRule = Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols();

        $rules = [
            'password' => [
                'required',
                'confirmed',
                'required_with:password_confirmation',
                $passwordRule,
            ],
            'password_confirmation' => [
                'required',
                'same:password',
            ],
        ];

        // If signup with social auth id enabled. User will not have a password.
        // In that case, we do not require the current password to change the password.
        if ($user->password !== null) {
            $rules = array_merge($rules, ['current_password' => ['required', 'current_password']]);
        }

        return $rules;
    }
}
