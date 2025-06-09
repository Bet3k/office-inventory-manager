<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class VerifyEmailAction
{
    public function __construct()
    {
        // Constructor can be used for dependency injection if needed
    }

    public function execute(Request $request): void
    {
        /** @var MustVerifyEmail $user */
        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            // Mark the email as verified
            $user->markEmailAsVerified();

            // Trigger the verified event
            event(new Verified($user));
        }
    }
}
