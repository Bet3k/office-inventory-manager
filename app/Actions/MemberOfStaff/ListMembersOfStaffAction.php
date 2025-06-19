<?php

namespace App\Actions\MemberOfStaff;

use App\Models\MemberOfStaff;
use App\Repository\MemberOfStaffRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

final class ListMembersOfStaffAction
{
    private MemberOfStaffRepository $memberOfStaffRepository;

    public function __construct(MemberOfStaffRepository $memberOfStaffRepository)
    {
        $this->memberOfStaffRepository = $memberOfStaffRepository;
    }

    /**
     * Returns paginated, filtered list of members of staff
     *
     * @param  Request  $request
     * @param  int  $perPage
     * @return LengthAwarePaginator<int, MemberOfStaff>
     */
    public function execute(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        return $this->memberOfStaffRepository->all($request, $perPage);
    }
}
