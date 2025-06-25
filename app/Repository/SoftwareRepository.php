<?php

namespace App\Repository;

use App\Models\Software;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Repository for managing software.
 */
class SoftwareRepository
{
    /**
     * Get all software.
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, Software>
     */
    public function all(Request $request): LengthAwarePaginator
    {
        return Software::query()
            ->when(
                $request->filled('search'),
                fn ($q) => $q->where('name', 'like', '%' . $request->string('search')->value() . '%')
            )
            ->when(
                $request->filled('status') && $request->string('status')->value() !== 'All',
                fn ($q) => $q->where('status', $request->string('status')->value())
            )
            ->orderBy(
                in_array($request->input('sort_field'), ['name', 'status'], true)
                    ? $request->string('sort_field')->value()
                    : 'created_at',
                in_array($request->input('sort_order'), ['asc', 'desc'], true)
                    ? $request->string('sort_order')->value()
                    : 'desc'
            )
            ->paginate(
                $request->filled('per_page')
                    ? $request->integer('per_page')
                    : 10
            )
            ->withQueryString();
    }

    /**
     * Get a single software by ID.
     *
     * @param  int|string  $id
     *
     * @return Software
     *
     * @throws ModelNotFoundException
     */
    public function get(int|string $id): Software
    {
        return Software::query()->findOrFail($id);
    }

    /**
     * Save (create or update) a software instance.
     *
     * @param  Software  $software
     *
     * @return Software
     */
    public function save(Software $software): Software
    {
        $software->save();

        return $software->refresh();
    }

    /**
     * Delete a software instance.
     *
     * @param  Software  $software
     *
     * @return bool|null
     *
     * @throws Exception
     */
    public function delete(Software $software): ?bool
    {
        return $software->delete();
    }
}
