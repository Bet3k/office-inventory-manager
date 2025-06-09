<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class DownloadCodesAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Mark the codes as downloaded for the authenticated user.
     */
    public function execute(User $user, Request $request): void
    {
        $this
            ->userRepository
            ->updateDownloadedCodes(
                $user,
                $request
                    ->boolean('downloaded_codes')
            );
    }
}
