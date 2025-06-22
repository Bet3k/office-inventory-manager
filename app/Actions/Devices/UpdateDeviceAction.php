<?php

namespace App\Actions\Devices;

use App\Dtos\DeviceDto;
use App\Models\Device;
use App\Models\User;
use App\Repository\DeviceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class UpdateDeviceAction
{
    private DeviceRepository $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(DeviceDto $dto, Device $device): ?Device
    {
        return DB::transaction(function () use ($dto, $device) {
            /** @var User $user */
            $user = Auth::user();

            $device->user_id = $user->id;
            $device->brand = $dto->brand;
            $device->type = $dto->type;
            $device->status = $dto->status;
            // If the device is Non-Functional, auto set service status to Decommissioned
            // in case the user forgets to set it
            $device->service_status = $dto->status === 'Non-Functional' ? 'Decommissioned' : $dto->serviceStatus;
            $device->serial_number = $dto->serialNumber;

            return $this->deviceRepository->save($device);
        });
    }
}
