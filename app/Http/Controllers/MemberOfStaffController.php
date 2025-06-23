<?php

namespace App\Http\Controllers;

use App\Actions\DeviceStaffMapping\ListMappingAction;
use App\Actions\MemberOfStaff\CreateMemberOfStaffAction;
use App\Actions\MemberOfStaff\DeleteMemberOfStaffAction;
use App\Actions\MemberOfStaff\ListMembersOfStaffAction;
use App\Actions\MemberOfStaff\UpdateMemberOfStaffAction;
use App\Dtos\MemberOfStaffDto;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\MemberOfStaffRequest;
use App\Models\MemberOfStaff;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class MemberOfStaffController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, ListMembersOfStaffAction $action): Response
    {
        $this->authorize('viewAny', MemberOfStaff::class);

        return Inertia::render('member-of-staff/index', [
            'membersOfStaff' => $action->execute($request),
            'filters' => $request->only(['name', 'per_page', 'sort_field', 'sort_order']),
        ]);
    }

    public function store(MemberOfStaffRequest $request, CreateMemberOfStaffAction $action): RedirectResponse
    {
        $this->authorize('create', MemberOfStaff::class);

        $dto = MemberOfStaffDto::fromRequest($request);

        try {
            $action->execute($dto);
            return back()->with('success', 'Member of staff created successfully.');
        } catch (Throwable $e) {
            Log::error('Member of Staff creation failed.', [
                'exception' => $e,
                'member_of_staff_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to create member of staff. Please try again.');
        }
    }

    public function show(Request $request, MemberOfStaff $memberOfStaff, ListMappingAction $action): Response
    {
        $this->authorize('view', $memberOfStaff);

        return Inertia::render('member-of-staff/staff-details', [
            'memberOfStaff' => MemberOfStaffDto::fromModel($memberOfStaff)->toArray(),
            'deviceStaffMappings' => $action->execute($request, $memberOfStaff),
            'hasResources' => $memberOfStaff->hasResources(),
        ]);
    }

    public function update(
        MemberOfStaffRequest $request,
        MemberOfStaff $memberOfStaff,
        UpdateMemberOfStaffAction $action
    ): RedirectResponse {
        $this->authorize('update', $memberOfStaff);

        $dto = MemberOfStaffDto::fromRequest($request);

        try {
            $action->execute($dto, $memberOfStaff);
            return back()->with('success', 'Member of staff updated successfully.');
        } catch (Throwable $e) {
            Log::error('Member of Staff update failed.', [
                'exception' => $e,
                'member_of_staff_id' => $memberOfStaff->id ?? null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to update member of staff. Please try again.');
        }
    }

    public function destroy(
        CurrentPasswordRequest $request,
        MemberOfStaff $memberOfStaff,
        DeleteMemberOfStaffAction $action
    ): RedirectResponse {
        $this->authorize('delete', $memberOfStaff);

        if ($memberOfStaff->hasResources()) {
            return back()->with('error', 'Staff still has devices.');
        }

        try {
            $action->execute($memberOfStaff);
            return to_route('member-of-staff.index')->with('success', 'Member of staff deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Member of Staff deletion failed.', [
                'exception' => $e,
                'member_of_staff_id' => $memberOfStaff->id ?? null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to delete member of staff. Please try again.');
        }
    }
}
