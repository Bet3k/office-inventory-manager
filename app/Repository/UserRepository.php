<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function __construct()
    {
    }

    /**
     * Create a new profile.
     *
     * @param  array<string, string|bool>  $data  User data.
     */
    public function create(array $data): User
    {
        return User::query()->create($data);
    }

    /**
     * Update an existing user.
     *
     * This method updates the user email.
     *
     * @param  User  $user  The profile to be updated.
     * @param  string  $email  The new profile data.
     */
    public function updateEmail(User $user, string $email): void
    {
        $normalized = strtolower($email);

        if ($user->email !== $normalized) {
            $user->email = $normalized;
            $user->email_verified_at = null;
            $user->save();
        }
    }

    public function updateDownloadedCodes(User $user, bool $downloaded): void
    {
        $user->downloaded_codes = $downloaded;
        $user->save();
    }
}
