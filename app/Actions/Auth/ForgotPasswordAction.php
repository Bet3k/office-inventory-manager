<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\PasswordResetRequest;
use App\Jobs\SendPasswordResetEmailJob;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordAction
{
    public function __construct()
    {
        // Constructor can be used for dependency injection if needed
    }

    public function execute(PasswordResetRequest $request): void
    {
        $user = User::query()
            ->where('email', $request->string('email')->value())->first();

        if (! $user instanceof User) {
            return;
        }

        $token = Str::random(64);

        PasswordResetToken::query()->updateOrInsert(
            ['user_id' => $user->id],
            [
                'id' => (string) Str::uuid(),
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        SendPasswordResetEmailJob::dispatch($user, $token);
    }
}
