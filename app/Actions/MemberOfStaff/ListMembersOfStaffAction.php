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
     * @return LengthAwarePaginator<int, MemberOfStaff>
     */
    public function execute(Request $request): LengthAwarePaginator
    {
        return $this->memberOfStaffRepository->all($request);
    }
}
