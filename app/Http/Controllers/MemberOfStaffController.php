<?php

namespace App\Http\Controllers;

use App\Actions\MemberOfStaff\CreateMemberOfStaffAction;
use App\Actions\MemberOfStaff\DeleteMemberOfStaffAction;
use App\Actions\MemberOfStaff\ListMembersOfStaffAction;
use App\Actions\MemberOfStaff\UpdateMemberOfStaffAction;
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
            'filters' => $request->only(['name', 'per_page']),
        ]);
    }

    public function store(MemberOfStaffRequest $request, CreateMemberOfStaffAction $action): RedirectResponse
    {
        $this->authorize('create', MemberOfStaff::class);

        try {
            $action->execute($request);
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

    public function show(MemberOfStaff $memberStaff)
    {
        $this->authorize('view', $memberStaff);

        return $memberStaff;
    }

    public function update(
        MemberOfStaffRequest $request,
        MemberOfStaff $memberStaff,
        UpdateMemberOfStaffAction $action
    ): RedirectResponse {
        $this->authorize('update', $memberStaff);

        try {
            $action->execute($request, $memberStaff);
            return back()->with('success', 'Member of staff updated successfully.');
        } catch (Throwable $e) {
            Log::error('Member of Staff update failed.', [
                'exception' => $e,
                'member_of_staff_id' => $memberStaff->id ?? null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to update member of staff. Please try again.');
        }
    }

    public function destroy(
        Request $request,
        MemberOfStaff $memberStaff,
        DeleteMemberOfStaffAction $action
    ): RedirectResponse {
        $this->authorize('delete', $memberStaff);

        try {
            $action->execute($memberStaff);
            return back()->with('success', 'Member of staff deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Member of Staff deletion failed.', [
                'exception' => $e,
                'member_of_staff_id' => $memberStaff->id ?? null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to delete member of staff. Please try again.');
        }
    }
}
