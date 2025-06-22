<?php

namespace App\Actions\Devices;

use App\Models\Device;
use App\Repository\DeviceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

readonly class ListDeviceAction
{
    private DeviceRepository $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * Returns paginated, filtered list of devices
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, Device>
     */
    public function execute(Request $request): LengthAwarePaginator
    {
        return $this->deviceRepository->all($request);
    }
}
