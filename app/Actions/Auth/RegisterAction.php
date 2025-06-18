<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Jobs\SendVerificationEmailJob;
use App\Models\User;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class RegisterAction
{
    /**
     * Create a new class instance.
     */
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
     * Create a new user with form data.
     *
     * @throws Throwable
     */
    public function execute(Request $request): User
    {
        return DB::transaction(function () use ($request): User {
            $user = $this->userRepository->create([
                'email' => strtolower($request->string('email')->value()),
                'password' => Hash::make($request->string('password')->value()),
                'downloaded_codes' => false,
                'is_active' => true,
            ]);

            $this->profileRepository->create([
                'user_id' => $user->id,
                'first_name' => Str::title($request
                    ->string('first_name')
                    ->value()),
                'last_name' => Str::title($request
                    ->string('last_name')
                    ->value()),
            ]);

            SendVerificationEmailJob::dispatch($user);

            return $user;
        });
    }
}
