<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Profile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Profile::class);

        return Inertia::render('auth/login');
    }

    public function store(RegisterRequest $request)
    {
        $this->authorize('create', Profile::class);

        return Profile::create($request->validated());
    }

    public function show(Profile $profile)
    {
        $this->authorize('view', $profile);

        return $profile;
    }

    public function update(RegisterRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $profile->update($request->validated());

        return $profile;
    }

    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);

        $profile->delete();

        return response()->json();
    }
}
