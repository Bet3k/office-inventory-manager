<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class NewPasswordAction
{
    public function __construct()
    {
        // Constructor can be used for dependency injection if needed
    }

    public function checkToken(object|string|null $userId): ?PasswordResetToken
    {
        return PasswordResetToken::query()->where('user_id', $userId)->first();
    }

    /**
     * Validate the token and check if it's expired
     *
     * @return array<int|string>|null Returns null if valid, or an error array if invalid
     */
    public function validateToken(?PasswordResetToken $record, string $token): ?array
    {
        if (! $record || ! Hash::check($token, $record->token)) {
            return [
                'code' => '401',
                'message' => 'Invalid token',
            ];
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return [
                'code' => '401',
                'message' => 'Token expired',
            ];
        }

        return null;
    }

    /**
     * Here we will attempt to reset the user's password.
     */
    public function execute(Request $request, User $user): void
    {
        $user->update([
            'password' => Hash::make($request->string('password')->value()),
        ]);
    }
}
