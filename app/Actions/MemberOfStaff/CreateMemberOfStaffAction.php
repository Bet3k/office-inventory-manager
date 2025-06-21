<?php

declare(strict_types=1);

namespace App\Actions\MemberOfStaff;

use App\Dtos\MemberOfStaffDto;
use App\Http\Requests\MemberOfStaffRequest;
use App\Models\MemberOfStaff;
use App\Repository\MemberOfStaffRepository;
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
    public function execute(MemberOfStaffRequest $request): ?MemberOfStaff
    {
        return DB::transaction(function () use ($request) {
            $dto = MemberOfStaffDto::fromRequest($request);

            $memberOfStaff = new MemberOfStaff();
            $memberOfStaff->first_name = $dto->firstName;
            $memberOfStaff->last_name = $dto->lastName;
            $memberOfStaff->user_id = $request->user()->id;

            return $this->memberOfStaffRepository->save($memberOfStaff);
        });
    }
}
