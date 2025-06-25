<?php

namespace App\Http\Controllers;

use App\Actions\Devices\CreateDeviceAction;
use App\Actions\Devices\DeleteDeviceAction;
use App\Actions\Devices\ListDeviceAction;
use App\Actions\Devices\UpdateDeviceAction;
use App\Dtos\DeviceDto;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use App\Models\MemberOfStaff;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class DeviceController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, ListDeviceAction $action): Response
    {
        $this->authorize('viewAny', Device::class);

        return Inertia::render('devices/index', [
            'devices' => $action->execute($request),
            'staffs' => MemberOfStaff::query()->get(),
            'permissions' => [
                'assign' => $request->user()->can('assign-device'),
                'create' => $request->user()->can('create-device'),
                'update' => $request->user()->can('update-device'),
                'delete' => $request->user()->can('delete-device'),
            ],
            'deviceAssignmentPermissions' => [
                'create' => $request->user()->can('create-device_staff_mapping'),
                'delete' => $request->user()->can('delete-device_staff_mapping'),
            ],
            'filters' => $request->only([
                'brand',
                'type',
                'serial_number',
                'status',
                'service_status',
                'sort_field',
                'sort_order',
                'per_page',
                'search',
            ]),
        ]);
    }

    public function store(DeviceRequest $request, CreateDeviceAction $action): RedirectResponse
    {
        $this->authorize('create', Device::class);

        $dto = DeviceDto::fromRequest($request);

        try {
            $action->execute($dto);
            return back()->with('success', 'Device created successfully.');
        } catch (Throwable $e) {
            Log::error('Device creation failed.', [
                'exception' => $e,
                'member_of_staff_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to create device. Please try again.');
        }
    }

    public function update(DeviceRequest $request, Device $device, UpdateDeviceAction $action): RedirectResponse
    {
        $this->authorize('update', $device);

        $dto = DeviceDto::fromRequest($request);

        try {
            $action->execute($dto, $device);
            return back()->with('success', 'Device update successfully.');
        } catch (Throwable $e) {
            Log::error('Device creation failed.', [
                'exception' => $e,
                'member_of_staff_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to update device. Please try again.');
        }
    }

    public function destroy(
        CurrentPasswordRequest $request,
        Device $device,
        DeleteDeviceAction $action
    ): RedirectResponse {
        $this->authorize('delete', $device);

        if ($device->hasResources()) {
            return back()->with('error', 'Device still assigned.');
        }

        try {
            $action->execute($device);
            return back()->with('success', 'Device deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Device deletion failed.', [
                'exception' => $e,
                'member_of_staff_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to delete device. Please try again.');
        }
    }
}
