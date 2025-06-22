<?php

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use Illuminate\Support\Str;
use InvalidArgumentException;

readonly class DeviceDto implements DtoContract
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $brand,
        public readonly string $type,
        public readonly string $serialNumber,
        public readonly string $status,
        public readonly string $serviceStatus,
    ) {
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof Device) {
            throw new InvalidArgumentException('Expected instance of Device');
        }

        return new self(
            id: $model->id,
            brand: $model->brand,
            type: $model->type,
            serialNumber: $model->serial_number,
            status: $model->status,
            serviceStatus: $model->service_status,
        );
    }

    public static function fromRequest(DeviceRequest $request): self
    {
        return new self(
            id: null,
            brand: trim(Str::title($request->string('brand')->value())),
            type: trim(Str::title($request->string('type')->value())),
            serialNumber: trim(Str::upper($request->string('serial_number')->value())),
            status: trim(Str::title($request->string('status')->value())),
            serviceStatus: trim(Str::title($request->string('service_status')->value())),
        );
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array{
     *      id: string|null,
     *      brand: string,
     *      type: string,
     *      serial_number: string,
     *      status: string,
     *      service_status: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'type' => $this->type,
            'serial_number' => $this->serialNumber,
            'status' => $this->status,
            'service_status' => $this->serviceStatus,
        ];
    }
}
