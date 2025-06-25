<?php

namespace App\Http\Controllers;

use App\Actions\Software\ListSoftwareAction;
use App\Http\Requests\SoftwareRequest;
use App\Models\Software;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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

    public function store(SoftwareRequest $request)
    {
        $this->authorize('create', Software::class);

        return Software::create($request->validated());
    }

    public function show(Software $software)
    {
        $this->authorize('view', $software);

        return $software;
    }

    public function update(SoftwareRequest $request, Software $software)
    {
        $this->authorize('update', $software);

        $software->update($request->validated());

        return $software;
    }

    public function destroy(Software $software)
    {
        $this->authorize('delete', $software);

        $software->delete();

        return response()->json();
    }
}
