<?php

namespace App\Http\Controllers;

use App\Actions\PersonalDataProcessed\CreatePersonalDataProcessedAction;
use App\Actions\PersonalDataProcessed\DeletePersonalDataProcessedAction;
use App\Actions\PersonalDataProcessed\ListPersonalDataProcessedAction;
use App\Actions\PersonalDataProcessed\UpdatePersonalDataProcessedAction;
use App\Dtos\PersonalDataProcessedDto;
use App\Dtos\SoftwareDto;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\PersonalDataProcessedRequest;
use App\Models\PersonalDataProcessed;
use App\Models\Software;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class PersonalDataProcessedController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, ListPersonalDataProcessedAction $action): Response
    {
        $this->authorize('viewAny', PersonalDataProcessed::class);

        return Inertia::render('personal-data-processed/index', [
            'personal_data_processed' => $action->execute($request),
            'filters' => $request->only(['search', 'sort_field', 'sort_order', 'per_page']),
            'permissions' => [
                'create' => $request->user()->can('create-personal-data-processed'),
                'update' => $request->user()->can('update-personal-data-processed'),
                'delete' => $request->user()->can('delete-personal-data-processed'),
            ],
        ]);
    }

    public function store(
        PersonalDataProcessedRequest $request,
        CreatePersonalDataProcessedAction $action
    ): RedirectResponse {
        $this->authorize('create', PersonalDataProcessed::class);

        $dto = PersonalDataProcessedDto::fromRequest($request);

        try {
            $action->execute($dto);
            return back()->with('success', 'Personal Data Processed created successfully.');
        } catch (Throwable $e) {
            Log::error('Personal Data Processed creation failed.', [
                'exception' => $e,
                'personal_data_processed_id' => null,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to create Personal Data Processed. Please try again.');
        }
    }


    public function update(
        PersonalDataProcessedRequest $request,
        PersonalDataProcessed $personalDataProcessed,
        UpdatePersonalDataProcessedAction $action
    ): RedirectResponse {
        $this->authorize('update', $personalDataProcessed);

        $dto = PersonalDataProcessedDto::fromRequest($request);

        try {
            $action->execute($dto, $personalDataProcessed);
            return back()->with('success', 'Personal Data Processed updated successfully.');
        } catch (Throwable $e) {
            Log::error('Personal Data Processed update failed.', [
                'exception' => $e,
                'software_id' => $personalDataProcessed->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to update Personal Data Processed. Please try again.');
        }
    }

    public function destroy(
        CurrentPasswordRequest $request,
        PersonalDataProcessed $personalDataProcessed,
        DeletePersonalDataProcessedAction $action
    ): RedirectResponse {
        $this->authorize('delete', $personalDataProcessed);

        try {
            $action->execute($personalDataProcessed);
            return back()->with('success', 'Personal Data Processed deleted successfully.');
        } catch (Throwable $e) {
            Log::error('Personal Data Processed deletion failed.', [
                'exception' => $e,
                'software_id' => $personalDataProcessed->id,
                'user_id' => $request->user()->id,
            ]);
            return back()->with('error', 'Failed to delete Personal Data Processed. Please try again.');
        }
    }
}
