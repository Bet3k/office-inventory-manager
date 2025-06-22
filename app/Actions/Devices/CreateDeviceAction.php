<?php

namespace App\Actions\Devices;

use App\Dtos\DeviceDto;
use App\Models\Device;
use App\Models\User;
use App\Repository\DeviceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class CreateDeviceAction
{
    private DeviceRepository $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(DeviceDto $dto): ?Device
    {
        return DB::transaction(function () use ($dto) {
            /** @var User $user */
            $user = Auth::user();

            $device = new Device();
            $device->brand = $dto->brand;
            $device->type = $dto->type;
            $device->status = $dto->status;
            $device->service_status = $dto->serviceStatus;
            $device->serial_number = $dto->serialNumber;
            $device->user_id = $user->id;

            return $this->deviceRepository->save($device);
        });
    }
}
