<?php

namespace App\Http\Controllers;

use App\Actions\Department\CreateDepartmentAction;
use App\Actions\Department\DeleteDepartmentAction;
use App\Actions\Department\ListDepartmentAction;
use App\Actions\Department\UpdateDepartmentAction;
use App\Dtos\DepartmentDto;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class DepartmentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, ListDepartmentAction $action): Response
    {
        $this->authorize('viewAny', Department::class);

        return Inertia::render('department/index', [
            'departments' => $action->execute($request),
            'filters' => $request->only(['search', 'sort_field', 'sort_order', 'per_page']),
            'permissions' => [
                'create' => $request->user()->can('create-department'),
                'update' => $request->user()->can('update-department'),
                'delete' => $request->user()->can('delete-department'),
            ],
        ]);
    }

    public function store(
        DepartmentRequest $request,
        CreateDepartmentAction $action
    ): RedirectResponse {
        $this->authorize('create', Department::class);

        $dto = DepartmentDto::fromRequest($request);

        try {
            $action->execute($dto);
            return back()->with('success', 'Department created successfully.');
        } catch (Throwable $e) {
            Log::error('Department creation failed.', [
                'exception' => $e,
                'department_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to create Department. Please try again.');
        }
    }

    public function update(
        DepartmentRequest $request,
        Department $department,
        UpdateDepartmentAction $action
    ): RedirectResponse {
        $this->authorize('update', $department);

        $dto = DepartmentDto::fromRequest($request);

        try {
            $action->execute($dto, $department);
            return back()->with('success', 'Department updated successfully.');
        } catch (Throwable $e) {
            Log::error('Department update failed.', [
                'exception' => $e,
                'department_id' => $department->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to update Department. Please try again.');
        }
    }

    public function destroy(
        CurrentPasswordRequest $request,
        Department $department,
        DeleteDepartmentAction $action
    ): RedirectResponse {
        $this->authorize('delete', $department);

        try {
            $action->execute($department);
            return back()->with('success', 'Department deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Department deletion failed.', [
                'exception' => $e,
                'department_id' => $department->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to delete Department. Please try again.');
        }
    }
}
