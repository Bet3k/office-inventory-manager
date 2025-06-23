<?php

namespace App\Actions\DeviceStaffMapping;

use App\Http\Requests\DeviceStaffMappingRequest;
use App\Models\Device;
use App\Models\DeviceStaffMapping;
use App\Models\User;
use App\Repository\DeviceStaffMappingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class CreatMappingAction
{
    private DeviceStaffMappingRepository $deviceStaffMappingRepository;

    public function __construct(DeviceStaffMappingRepository $deviceStaffMappingRepository)
    {
        $this->deviceStaffMappingRepository = $deviceStaffMappingRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(DeviceStaffMappingRequest $request): ?DeviceStaffMapping
    {
        return DB::transaction(function () use ($request) {
            /** @var User $user */
            $user = Auth::user();

            $device = Device::query()->findOrFail($request->string('device_id')->value());
            $device->service_status = 'Assigned';
            $device->user_id = $user->id;
            $device->save();

            $mapping = new DeviceStaffMapping();
            $mapping->device_id = $request->string('device_id')->value();
            $mapping->member_of_staff_id = $request->string('member_of_staff_id')->value();
            $mapping->user_id = $user->id;

            return $this->deviceStaffMappingRepository->save($mapping);
        });
    }
}
