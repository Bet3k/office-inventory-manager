<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Profile\UpdateProfileAction;
use App\Dtos\ProfileDto;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    public function show(Request $request): Response
    {
        $this->authorize('view', $request->user()->profile);

        return Inertia::render('profile/index');
    }

    /**
     * @throws Throwable
     */
    public function update(
        ProfileUpdateRequest $request,
        Profile $profile,
        UpdateProfileAction $action
    ): RedirectResponse {
        $this->authorize('update', $profile);

        $dto = ProfileDto::fromUpdateRequest($request);

        $email = trim(Str::lower($request->string('email')->value()));

        $action->execute($profile, $dto, $email);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function destroy(CurrentPasswordRequest $request, Profile $profile): RedirectResponse
    {
        $this->authorize('delete', $request->user()->profile);

        $user = $profile->user;

        if ($user->hasResources()) {
            return back()->with('error', 'Please delete associated data first.');
        }

        $user->delete();

        /** @var StatefulGuard $guard */
        $guard = Auth::guard('web');
        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login')->with('success', 'Profile deleted successfully. Goodbye!');
    }
}
