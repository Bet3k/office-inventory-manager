<?php

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Http\Requests\MemberOfStaffRequest;
use App\Models\MemberOfStaff;
use Illuminate\Support\Str;
use InvalidArgumentException;

readonly class MemberOfStaffDto implements DtoContract
{
    public function __construct(
        public readonly ?string $id,
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

    public static function fromRequest(MemberOfStaffRequest $request): self
    {
        return new self(
            id: null,
            firstName: trim(Str::title($request->string('first_name')->value())),
            lastName: trim(Str::title($request->string('last_name')->value())),
        );
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array{
     *      id: string|null,
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
