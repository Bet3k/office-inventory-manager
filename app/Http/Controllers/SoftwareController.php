<?php

namespace App\Http\Controllers;

use App\Actions\Software\CreateSoftwareAction;
use App\Actions\Software\DeleteSoftwareAction;
use App\Actions\Software\ListSoftwareAction;
use App\Actions\Software\UpdateSoftwareAction;
use App\Dtos\SoftwareDto;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\SoftwareRequest;
use App\Models\Software;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class SoftwareController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, ListSoftwareAction $action): Response
    {
        $this->authorize('viewAny', Software::class);

        return Inertia::render('software/index', [
            'software' => $action->execute($request),
            'filters' => $request->only(['search', 'status', 'sort_field', 'sort_order', 'per_page']),
            'permissions' => [
                'create' => $request->user()->can('create-software'),
                'update' => $request->user()->can('update-software'),
                'delete' => $request->user()->can('delete-software'),
            ],
        ]);
    }

    public function store(SoftwareRequest $request, CreateSoftwareAction $action): RedirectResponse
    {
        $this->authorize('create', Software::class);

        $dto = SoftwareDto::fromRequest($request);

        try {
            $action->execute($dto);
            return back()->with('success', 'Software created successfully.');
        } catch (Throwable $e) {
            Log::error('Software creation failed.', [
                'exception' => $e,
                'software_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to create software. Please try again.');
        }
    }

    public function update(SoftwareRequest $request, Software $software, UpdateSoftwareAction $action): RedirectResponse
    {
        $this->authorize('update', $software);

        $dto = SoftwareDto::fromRequest($request);

        try {
            $action->execute($dto, $software);
            return back()->with('success', 'Software updated successfully.');
        } catch (Throwable $e) {
            Log::error('Software update failed.', [
                'exception' => $e,
                'software_id' => $software->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to update software. Please try again.');
        }
    }

    public function destroy(
        CurrentPasswordRequest $request,
        Software $software,
        DeleteSoftwareAction $action
    ): RedirectResponse {
        $this->authorize('delete', $software);

        try {
            $action->execute($software);
            return back()->with('success', 'Software deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Software deletion failed.', [
                'exception' => $e,
                'software_id' => $software->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to delete software. Please try again.');
        }
    }
}
