<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UserSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function logoutCurrent(Request $request, string $session): RedirectResponse
    {
        $session = UserSession::query()->where('id', $session)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $session->delete();

        return back()
            ->with('success', 'Session successfully logged out.');
    }

    public function logoutAll(Request $request): RedirectResponse
    {
        $session = UserSession::query()
            ->where('user_id', $request->user()->id)
            ->get();

        foreach ($session as $s) {
            $s->delete();
        }

        return back()
            ->with('success', 'Session successfully logged out.');
    }
}
