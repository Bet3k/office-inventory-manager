<?php

namespace App\Http\Controllers;

use App\Actions\DeviceStaffMapping\CreatMappingAction;
use App\Actions\DeviceStaffMapping\DeleteMappingAction;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\DeviceStaffMappingRequest;
use App\Models\DeviceStaffMapping;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class DeviceStaffMappingController extends Controller
{
    use AuthorizesRequests;

    public function store(DeviceStaffMappingRequest $request, CreatMappingAction $action): RedirectResponse
    {
        $this->authorize('create', DeviceStaffMapping::class);

        try {
            $action->execute($request);
            return back()->with('success', 'Device assigned successfully.');
        } catch (Throwable $e) {
            Log::error('Device assignment failed.', [
                'exception' => $e,
                'member_of_staff_id' => $request->string('member_of_staff_id')->value(),
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to assign device. Please try again.');
        }
    }

    public function destroy(
        CurrentPasswordRequest $request,
        DeviceStaffMapping $deviceStaffMapping,
        DeleteMappingAction $action
    ): RedirectResponse {
        $this->authorize('delete', $deviceStaffMapping);
        try {
            $action->execute($deviceStaffMapping);
            return back()->with('success', 'Device returned deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Device return failed.', [
                'exception' => $e,
                'member_of_staff_id' => $deviceStaffMapping->member_of_staff_id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to return device. Please try again.');
        }
    }
}
