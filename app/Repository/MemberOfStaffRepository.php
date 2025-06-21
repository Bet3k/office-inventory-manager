<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\MemberOfStaff;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class MemberOfStaffRepository
{
    /**
     * Returns all member of staffs
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, MemberOfStaff>
     */
    public function all(Request $request): LengthAwarePaginator
    {
        $query = MemberOfStaff::query();

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->input('name').'%')
                    ->orWhere('last_name', 'like', '%'.$request->input('name').'%');
            });
        }

        $sortField = $request->input('sort_field');
        $sortOrder = $request->input('sort_order');

        $allowedFields = ['first_name', 'last_name'];
        $allowedOrders = ['asc', 'desc'];

        if (in_array($sortField, $allowedFields, true) && in_array($sortOrder, $allowedOrders, true)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($request->input('per_page'))->withQueryString();
    }

    /**
     * Returns member of staff by id
     *
     * @param  string  $id
     *
     * @return MemberOfStaff
     */
    public function get(string $id): MemberOfStaff
    {
        return MemberOfStaff::query()->findOrFail($id);
    }

    /**
     * Saves member of staff
     *
     * @param  MemberOfStaff  $memberOfStaff
     *
     * @return MemberOfStaff
     */
    public function save(MemberOfStaff $memberOfStaff): MemberOfStaff
    {
        $memberOfStaff->save();

        return $memberOfStaff->refresh();
    }

    /**
     * Delete a $MODEL_CLASS_SINGULAR instance.
     *
     * @param  MemberOfStaff  $memberOfStaff
     *
     * @return bool|null
     */
    public function delete(MemberOfStaff $memberOfStaff): ?bool
    {
        return $memberOfStaff->delete();
    }
}
