<?php

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Http\Requests\PersonalDataProcessedRequest;
use App\Models\PersonalDataProcessed;
use Illuminate\Support\Str;
use InvalidArgumentException;

class PersonalDataProcessedDto implements DtoContract
{
    public function __construct(
        public ?string $id,
        public string $name,
    ) {
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof PersonalDataProcessed) {
            throw new InvalidArgumentException('Expected instance of PersonalDataProcessed');
        }

        return new self(
            id: $model->id,
            name: $model->name,
        );
    }

    public static function fromRequest(PersonalDataProcessedRequest $request): self
    {
        return new self(
            id: null,
            name: trim(Str::title($request->string('name')->value())),
        );
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array{
     *      id: string|null,
     *      name: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
