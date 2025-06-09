<?php

namespace App\Actions\Auth;

use App\Models\ConnectedAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\AbstractUser;

class GoogleLinkAction
{
    public function __construct()
    {
        // Constructor can be used for dependency injection if needed
    }

    public function execute(
        AbstractUser $googleUser,
        User $authUser
    ): RedirectResponse {
        session(['linkAuth' => true]);

        // Check if an account is already linked
        if (
            ConnectedAccount::query()
                ->where('identifier', $googleUser->getEmail())
                ->where('service', 'google')
                ->exists()
        ) {
            return to_route('settings.create')
                ->with('warning', __('This Google account is already linked.'));
        }

        $authUser->connectedAccounts()->create([
            'service' => 'google',
            'identifier' => $googleUser->getEmail(),
            'name' => $googleUser->getName(),
        ]);

        return to_route('settings.create')
            ->with('success', __('Google account linked successfully.'));
    }
}
