<?php

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Http\Requests\SoftwareRequest;
use App\Models\Software;
use Illuminate\Support\Str;
use InvalidArgumentException;

readonly class SoftwareDto implements DtoContract
{
    public function __construct(
        public ?string $id,
        public string $name,
        public string $status,
    ) {
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof Software) {
            throw new InvalidArgumentException('Expected instance of Software');
        }

        return new self(
            id: $model->id,
            name: $model->name,
            status: $model->status,
        );
    }

    public static function fromRequest(SoftwareRequest $request): self
    {
        return new self(
            id: null,
            name: trim(Str::title($request->string('name')->value())),
            status: trim(Str::title($request->string('status')->value())),
        );
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array{
     *      id: string|null,
     *      name: string,
     *      status: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
        ];
    }
}
