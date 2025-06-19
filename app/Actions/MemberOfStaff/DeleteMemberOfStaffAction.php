<?php

declare(strict_types=1);

namespace App\Actions\MemberOfStaff;

use App\Models\MemberOfStaff;
use App\Repository\MemberOfStaffRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

final class DeleteMemberOfStaffAction
{
    private MemberOfStaffRepository $memberOfStaffRepository;
    public function __construct(MemberOfStaffRepository $memberOfStaffRepository)
    {
        $this->memberOfStaffRepository = $memberOfStaffRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(MemberOfStaff $memberOfStaff): ?bool
    {
        return DB::transaction(function () use ($memberOfStaff) {
            return $this->memberOfStaffRepository->delete($memberOfStaff);
        });
    }
}
