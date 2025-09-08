<?php

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Http\Requests\PersonalDataTypeRequest;
use App\Models\PersonalDataType;
use Illuminate\Support\Str;
use InvalidArgumentException;

class PersonalDataTypeDto implements DtoContract
{
    public function __construct(
        public ?string $id,
        public string $data_type,
    ) {
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof PersonalDataType) {
            throw new InvalidArgumentException('Expected instance of PersonalDataType');
        }

        return new self(
            id: $model->id,
            data_type: $model->data_type,
        );
    }

    public static function fromRequest(PersonalDataTypeRequest $request): self
    {
        return new self(
            id: null,
            data_type: trim(Str::title($request->string('data_type')->value())),
        );
    }

    /**
     * @return array{
     *      id: string|null,
     *      data_type: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'data_type' => $this->data_type,
        ];
    }
}
