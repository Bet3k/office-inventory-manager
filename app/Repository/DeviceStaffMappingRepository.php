<?php

namespace App\Repository;

use App\Models\Device;
use App\Models\DeviceStaffMapping;
use App\Models\MemberOfStaff;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Repository for managing device staff mappings.
 */
class DeviceStaffMappingRepository
{
    /**
     * Returns all member of staffs
     *
     * @param  Request  $request
     *
     * @param  MemberOfStaff  $memberOfStaff
     *
     * @return LengthAwarePaginator<int, Device>
     */
    public function all(Request $request, MemberOfStaff $memberOfStaff): LengthAwarePaginator
    {
        $query = DeviceStaffMapping::query()
            ->where('member_of_staff_id', $memberOfStaff->id)
            ->join('devices', 'device_staff_mappings.device_id', '=', 'devices.id')
            ->select('device_staff_mappings.id as mapping_id', 'devices.*');

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order');

        $allowedFields = ['type', 'serial_number', 'status', 'service_status', 'brand'];
        $allowedOrders = ['asc', 'desc'];

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('brand', 'like', '%'.$request->input('search').'%')
                    ->orWhere('type', 'like', '%'.$request->input('search').'%')
                    ->orWhere('status', 'like', '%'.$request->input('search').'%')
                    ->orWhere('service_status', 'like', '%'.$request->input('search').'%')
                    ->orWhere('serial_number', 'like', '%'.$request->input('search').'%');
            });
        }

        if (in_array($sortField, $allowedFields, true) && in_array($sortOrder, $allowedOrders, true)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($request->input('per_page'))->withQueryString();
    }

    /**
     * Get a single device staff mapping by ID.
     *
     * @param  int|string  $id
     *
     * @return DeviceStaffMapping
     *
     * @throws ModelNotFoundException
     */
    public function get(int|string $id): DeviceStaffMapping
    {
        return DeviceStaffMapping::query()->findOrFail($id);
    }

    /**
     * Save (create or update) a device staff mapping instance.
     *
     * @param  DeviceStaffMapping  $deviceStaffMapping
     *
     * @return DeviceStaffMapping
     */
    public function save(DeviceStaffMapping $deviceStaffMapping): DeviceStaffMapping
    {
        $deviceStaffMapping->save();

        return $deviceStaffMapping->refresh();
    }

    /**
     * Delete a device staff mapping instance.
     *
     * @param  DeviceStaffMapping  $deviceStaffMapping
     *
     * @return bool|null
     *
     * @throws Exception
     */
    public function delete(DeviceStaffMapping $deviceStaffMapping): ?bool
    {
        return $deviceStaffMapping->delete();
    }
}
