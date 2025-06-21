<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Models\Profile;
use Carbon\Carbon;
use InvalidArgumentException;

readonly class ProfileDto implements DtoContract
{
    public function __construct(
        public string $id,
        public string $first_name,
        public string $last_name,
        public string|null $gender,
        public Carbon|null $date_of_birth,
    ) {
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof Profile) {
            throw new InvalidArgumentException('Expected instance of Profile');
        }

        return new self(
            id: $model->id,
            first_name: $model->first_name,
            last_name: $model->last_name,
            gender: $model->gender,
            date_of_birth: $model->date_of_birth,
        );
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array{
     *      id: string,
     *      first_name: string,
     *      last_name: string,
     *      gender: string|null,
     *      date_of_birth: string|null,
     * }
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
