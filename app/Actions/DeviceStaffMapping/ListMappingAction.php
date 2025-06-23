<?php

namespace App\Actions\DeviceStaffMapping;

use App\Models\Device;
use App\Models\MemberOfStaff;
use App\Repository\DeviceStaffMappingRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

readonly class ListMappingAction
{
    private DeviceStaffMappingRepository $deviceStaffMappingRepository;

    public function __construct(DeviceStaffMappingRepository $deviceStaffMappingRepository)
    {
        $this->deviceStaffMappingRepository = $deviceStaffMappingRepository;
    }

    /**
     * Returns paginated, filtered list of devices
     *
     * @param  Request  $request
     *
     * @param  MemberOfStaff  $memberOfStaff
     *
     * @return LengthAwarePaginator<int, Device>
     */
    public function execute(Request $request, MemberOfStaff $memberOfStaff): LengthAwarePaginator
    {
        return $this->deviceStaffMappingRepository->all($request, $memberOfStaff);
    }
}
