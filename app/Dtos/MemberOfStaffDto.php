<?php

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Models\MemberOfStaff;
use InvalidArgumentException;

readonly class MemberOfStaffDto implements DtoContract
{
    public function __construct(
        public readonly string $id,
        public readonly string $firstName,
        public readonly string $lastName,
    ) {
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof MemberOfStaff) {
            throw new InvalidArgumentException('Expected instance of MemberOfStaff');
        }

        return new self(
            id: $model->id,
            firstName: $model->first_name,
            lastName: $model->last_name,
        );
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array{
     *      id: string,
     *      first_name: string,
     *      last_name: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}
