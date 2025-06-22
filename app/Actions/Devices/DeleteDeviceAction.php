<?php

namespace App\Actions\Devices;

use App\Models\Device;
use App\Repository\DeviceRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class DeleteDeviceAction
{
    private DeviceRepository $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(Device $device): ?bool
    {
        return DB::transaction(function () use ($device) {
            return $this->deviceRepository->delete($device);
        });
    }
}
