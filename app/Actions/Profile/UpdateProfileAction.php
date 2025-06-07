<?php

namespace App\Actions\Profile;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Str;

class UpdateProfileAction
{
    private ProfileRepository $profileRepository;

    private UserRepository $userRepository;

    public function __construct(
        ProfileRepository $profileRepository,
        UserRepository $userRepository
    ) {
        $this->profileRepository = $profileRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Update the authenticated user profile.
     */
    public function execute(Profile $profile, ProfileUpdateRequest $request): void
    {
        $profileData = [
            'first_name' => Str::title($request->string('first_name')->value()),
            'last_name' => Str::title($request->string('last_name')->value()),
            'gender' => strtolower($request->string('gender')->value()),
            'date_of_birth' => $request->string('date_of_birth')->value(),
        ];

        $this->userRepository
            ->updateEmail($profile->user, strtolower($request->string('email')->value()));

        $this->profileRepository->update($profile, $profileData);
    }
}
