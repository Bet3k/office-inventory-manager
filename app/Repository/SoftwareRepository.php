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
        $query = Software::query();

        $filters = ['name', 'status'];

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->input('search').'%')
                    ->orWhere('status', 'like', '%'.$request->input('search').'%');
            });
        }

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order');

        $allowedFields = $filters;
        $allowedOrders = ['asc', 'desc'];

        if (in_array($sortField, $allowedFields, true) && in_array($sortOrder, $allowedOrders, true)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($request->input('per_page'))->withQueryString();
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
