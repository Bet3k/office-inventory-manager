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

readonly class CreateMemberOfStaffAction
{
    private MemberOfStaffRepository $memberOfStaffRepository;
    public function __construct(MemberOfStaffRepository $memberOfStaffRepository)
    {
        $this->memberOfStaffRepository = $memberOfStaffRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(MemberOfStaffDto $dto): ?MemberOfStaff
    {
        return DB::transaction(function () use ($dto) {
            /** @var User $user */
            $user = Auth::user();

            $memberOfStaff = new MemberOfStaff();
            $memberOfStaff->first_name = $dto->firstName;
            $memberOfStaff->last_name = $dto->lastName;
            $memberOfStaff->user_id = $user->id;

            return $this->memberOfStaffRepository->save($memberOfStaff);
        });
    }
}
