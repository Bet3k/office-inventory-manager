<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Models\Profile;
use Carbon\Carbon;

readonly class ProfileDto
{
    public function __construct(
        public string $id,
        public string $first_name,
        public string $last_name,
        public string|null $gender,
        public Carbon|null $date_of_birth,
    ) {
    }

    public static function fromModel(Profile $profile): self
    {
        return new self(
            id: $profile->id,
            first_name: $profile->first_name,
            last_name: $profile->last_name,
            gender: $profile->gender,
            date_of_birth: $profile->date_of_birth,
        );
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
        ];
    }
}
