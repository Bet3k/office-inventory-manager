<?php

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Support\Str;
use InvalidArgumentException;

class DepartmentDto implements DtoContract
{
    public function __construct(
        public ?string $id,
        public string $department,
    ) {
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof Department) {
            throw new InvalidArgumentException('Expected instance of Department');
        }

        return new self(
            id: $model->id,
            department: $model->department,
        );
    }

    public static function fromRequest(DepartmentRequest $request): self
    {
        return new self(
            id: null,
            department: trim(Str::title($request->string('department')->value())),
        );
    }

    /**
     * @return array{
     *      id: string|null,
     *      department: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'department' => $this->department,
        ];
    }
}
