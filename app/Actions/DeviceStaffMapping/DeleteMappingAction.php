<?php

namespace App\Actions\DeviceStaffMapping;

use App\Models\Device;
use App\Models\DeviceStaffMapping;
use App\Repository\DeviceStaffMappingRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class DeleteMappingAction
{
    private DeviceStaffMappingRepository $deviceStaffMappingRepository;

    public function __construct(DeviceStaffMappingRepository $deviceStaffMappingRepository)
    {
        $this->deviceStaffMappingRepository = $deviceStaffMappingRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(DeviceStaffMapping $deviceStaffMapping): ?bool
    {
        return DB::transaction(function () use ($deviceStaffMapping) {
            $device = Device::query()->findOrFail($deviceStaffMapping->device_id);
            $device->service_status = 'Available';
            $device->save();

            return $this->deviceStaffMappingRepository->delete($deviceStaffMapping);
        });
    }
}
