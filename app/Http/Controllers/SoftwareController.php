<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoftwareRequest;
use App\Models\Software;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SoftwareController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Software::class);

        return Software::all();
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
