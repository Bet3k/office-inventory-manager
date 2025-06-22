<?php

declare(strict_types=1);

namespace App\Actions\MemberOfStaff;

use App\Dtos\MemberOfStaffDto;
use App\Models\MemberOfStaff;
use App\Models\User;
use App\Repository\MemberOfStaffRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class UpdateMemberOfStaffAction
{
    private MemberOfStaffRepository $memberOfStaffRepository;
    public function __construct(MemberOfStaffRepository $memberOfStaffRepository)
    {
        $this->memberOfStaffRepository = $memberOfStaffRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(MemberOfStaffDto $dto, MemberOfStaff $memberOfStaff): ?MemberOfStaff
    {
        return DB::transaction(function () use ($dto, $memberOfStaff) {
            /** @var User $user */
            $user = Auth::user();

            $memberOfStaff->first_name = $dto->firstName;
            $memberOfStaff->last_name = $dto->lastName;
            $memberOfStaff->user_id = $user->id;

            return $this->memberOfStaffRepository->save($memberOfStaff);
        });
    }
}
