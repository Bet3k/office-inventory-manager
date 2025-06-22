<?php

namespace App\Repository;

use App\Models\Device;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Repository for managing devices.
 */
class DeviceRepository
{
    /**
     * Returns all member of staffs
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, Device>
     */
    public function all(Request $request): LengthAwarePaginator
    {
        $query = Device::query();

        $filters = ['brand', 'type', 'serial_number', 'status', 'service_status'];
        // Uncomment the following lines if you want to filter by ui table columns
        /*foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, 'like', '%' . $request->input($filter) . '%');
            }
        }*/

        // Uses one search field to filter multiple columns
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('brand', 'like', '%'.$request->input('search').'%')
                    ->orWhere('type', 'like', '%'.$request->input('search').'%')
                    ->orWhere('status', 'like', '%'.$request->input('search').'%')
                    ->orWhere('service_status', 'like', '%'.$request->input('search').'%')
                    ->orWhere('serial_number', 'like', '%'.$request->input('search').'%');
            });
        }

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order');

        $allowedFields = $filters;
        $allowedOrders = ['asc', 'desc'];

        if (in_array($sortField, $allowedFields, true) && in_array($sortOrder, $allowedOrders, true)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($request->input('per_page'))->withQueryString();
    }

    /**
     * Get a single device by ID.
     *
     * @param  int|string  $id
     *
     * @return Device
     *
     * @throws ModelNotFoundException
     */
    public function get(int|string $id): Device
    {
        return Device::query()->findOrFail($id);
    }

    /**
     * Save (create or update) a device instance.
     *
     * @param  Device  $device
     *
     * @return Device
     */
    public function save(Device $device): Device
    {
        $device->save();

        return $device->refresh();
    }

    /**
     * Delete a device instance.
     *
     * @param  Device  $device
     *
     * @return bool|null
     *
     * @throws Exception
     */
    public function delete(Device $device): ?bool
    {
        return $device->delete();
    }
}
