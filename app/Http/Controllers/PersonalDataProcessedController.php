<?php

namespace App\Http\Controllers;

use App\Actions\PersonalDataProcessed\CreatePersonalDataProcessedAction;
use App\Actions\PersonalDataProcessed\ListPersonalDataProcessedAction;
use App\Dtos\PersonalDataProcessedDto;
use App\Dtos\SoftwareDto;
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

    public function show(PersonalDataProcessed $personalDataProcessed)
    {
        $this->authorize('view', $personalDataProcessed);

        return $personalDataProcessed;
    }

    public function update(PersonalDataProcessedRequest $request, PersonalDataProcessed $personalDataProcessed)
    {
        $this->authorize('update', $personalDataProcessed);

        $personalDataProcessed->update($request->validated());

        return $personalDataProcessed;
    }

    public function destroy(PersonalDataProcessed $personalDataProcessed)
    {
        $this->authorize('delete', $personalDataProcessed);

        $personalDataProcessed->delete();

        return response()->json();
    }
}
