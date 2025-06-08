<?php

namespace App\Http\Controllers;

use App\Dtos\SessionDto;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $currentSessionId = session()->getId();

        $sessions = $user->sessions()->get();

        $recentlyConfirmed = time() - session('auth.password_confirmed_at', 0) < config('auth.password_timeout');

        return Inertia::render('settings/index', [
            'sessions' => SessionDto::fromCollection($sessions, $currentSessionId),
            'recentlyConfirmedPassword' => $recentlyConfirmed,
            'twoFactorEnabled' => isset($user->two_factor_secret),
            'setupCode' => $user->two_factor_secret ? decrypt($user->two_factor_secret) : '',
        ]);
    }
}
