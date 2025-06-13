<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Profile\DownloadCodesAction;
use App\Dtos\SessionDto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $recentlyConfirmed = time() - session('auth.password_confirmed_at', 0) < config('auth.password_timeout');

        return Inertia::render('settings/index', [
            'sessions' => SessionDto::fromCollection($user->sessions, session()->getId()),
            'recentlyConfirmedPassword' => $recentlyConfirmed,
            'twoFactorEnabled' => isset($user->two_factor_secret),
            'setupCode' => $user->two_factor_secret ? decrypt($user->two_factor_secret) : '',
            'connectedAccounts' => $user->connectedAccounts,
            'linkAuth' => session()->pull('linkAuth'),
        ]);
    }

    public function update(Request $request, DownloadCodesAction $downloadCodesAction): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $downloadCodesAction->execute($user, $request);

        return back()
            ->with(
                'success',
                $request->boolean('downloaded_codes') ?
                    'Recovery codes downloaded successfully.' :
                    'Recovery codes re-generated.'
            );
    }
}
