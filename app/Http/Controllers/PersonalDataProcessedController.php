<?php

namespace App\Http\Controllers;

use App\Actions\PersonalDataProcessed\ListPersonalDataProcessedAction;
use App\Http\Requests\PersonalDataProcessedRequest;
use App\Models\PersonalDataProcessed;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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

    public function store(PersonalDataProcessedRequest $request)
    {
        $this->authorize('create', PersonalDataProcessed::class);

        return PersonalDataProcessed::create($request->validated());
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
