<?php

namespace App\Repository;

use App\Models\Profile;

class ProfileRepository
{
    public function __construct()
    {
    }

    /**
     * Create a new profile.
     *
     * @param  array<string, string>  $data  Profile data.
     */
    public function create(array $data): Profile
    {
        return Profile::query()->create($data);
    }

    /**
     * Update an existing profile.
     *
     * This method updates the profile’s first name, last name, and gender.
     *
     * @param  Profile  $profile  The profile to be updated.
     * @param  array<string, string>  $data  Profile data.
     */
    public function update(Profile $profile, array $data): void
    {
        $profile->update([
            'first_name' => str($data['first_name'])->title(),
            'last_name' => str($data['last_name'])->title(),
            'gender' => str($data['gender'])->lower(),
            'date_of_birth' => $data['date_of_birth'],
        ]);
    }
}
