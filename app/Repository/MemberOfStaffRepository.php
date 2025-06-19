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
     * @param  int  $perPage
     * @return LengthAwarePaginator<int, MemberOfStaff>
     */
    public function all(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        $query = MemberOfStaff::query();

        if (!empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                    ->orWhere('last_name', 'like', '%'.$request->search.'%');
            });
        }

        return $query->paginate($perPage)->withQueryString();
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
