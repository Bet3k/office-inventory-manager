<?php

namespace App\Http\Controllers;

use App\Models\ConnectedAccount;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class ConnectedAccountController extends Controller
{
    use AuthorizesRequests;

    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirectToGoogle(): SymfonyRedirectResponse
    {
        /** @var User $user */
        $user = request()->user();
        $userId = encrypt($user->id);

        $cacheKey = 'google_login_'.request()->ip();
        Cache::put($cacheKey, false, now()->addMinutes(10));

        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');

        return $driver->with(['state' => 'link_'.$userId])->redirect();
    }

    /**
     * Delete connection
     */
    public function destroy(Request $request, ConnectedAccount $connectedAccount): RedirectResponse
    {
        $this->authorize('delete', $request->user());

        $connectedAccount->delete();

        return back()->with('success', 'Connected account deleted successfully');
    }
}
