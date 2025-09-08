<?php

namespace App\Http\Controllers;

use App\Actions\PersonalDataType\CreatePersonalDataTypeAction;
use App\Actions\PersonalDataType\DeletePersonalDataTypeAction;
use App\Actions\PersonalDataType\ListPersonalDataTypesAction;
use App\Actions\PersonalDataType\UpdatePersonalDataTypeAction;
use App\Dtos\PersonalDataTypeDto;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\PersonalDataTypeRequest;
use App\Models\PersonalDataType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class PersonalDataTypeController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, ListPersonalDataTypesAction $action): Response
    {
        $this->authorize('viewAny', PersonalDataType::class);

        return Inertia::render('personal-data-type/index', [
            'personal_data_type' => $action->execute($request),
            'filters' => $request->only(['search', 'sort_field', 'sort_order', 'per_page']),
            'permissions' => [
                'create' => $request->user()->can('create-personal-data-type'),
                'update' => $request->user()->can('update-personal-data-type'),
                'delete' => $request->user()->can('delete-personal-data-type'),
            ],
        ]);
    }

    public function store(
        PersonalDataTypeRequest $request,
        CreatePersonalDataTypeAction $action
    ): RedirectResponse {
        $this->authorize('create', PersonalDataType::class);

        $dto = PersonalDataTypeDto::fromRequest($request);

        try {
            $action->execute($dto);
            return back()->with('success', 'Personal Data Type created successfully.');
        } catch (Throwable $e) {
            Log::error('Personal Data Type creation failed.', [
                'exception' => $e,
                'personal_data_type_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to create Personal Data Type. Please try again.');
        }
    }

    public function update(
        PersonalDataTypeRequest $request,
        PersonalDataType $personalDataType,
        UpdatePersonalDataTypeAction $action
    ): RedirectResponse {
        $this->authorize('update', $personalDataType);

        $dto = PersonalDataTypeDto::fromRequest($request);

        try {
            $action->execute($dto, $personalDataType);
            return back()->with('success', 'Personal Data Type updated successfully.');
        } catch (Throwable $e) {
            Log::error('Personal Data Type update failed.', [
                'exception' => $e,
                'personal_data_type_id' => $personalDataType->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to update Personal Data Type. Please try again.');
        }
    }

    public function destroy(
        CurrentPasswordRequest $request,
        PersonalDataType $personalDataType,
        DeletePersonalDataTypeAction $action
    ): RedirectResponse {
        $this->authorize('delete', $personalDataType);

        try {
            $action->execute($personalDataType);
            return back()->with('success', 'Personal Data Type deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Personal Data Type deletion failed.', [
                'exception' => $e,
                'personal_data_type_id' => $personalDataType->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to delete Personal Data Type. Please try again.');
        }
    }
}
