<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;

readonly class UserDto
{
    public function __construct(
        public string $id,
        public string $email,
        public bool $downloaded_codes,
        public bool $is_active,
        public Carbon|null $last_login_at,
        public Profile $profile,
    ) {
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'downloaded_codes' => $this->downloaded_codes,
            'is_active' => $this->is_active,
            'last_login_at' => $this->last_login_at,
            'profile' => ProfileDto::fromModel($this->profile)->toArray(),
        ];
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            email: $user->email,
            downloaded_codes: $user->downloaded_codes,
            is_active: $user->is_active,
            last_login_at: $user->last_login_at,
            profile: $user->profile,
        );
    }
}
