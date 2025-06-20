<?php

declare(strict_types=1);

namespace App\Actions\MemberOfStaff;

use App\Http\Requests\MemberOfStaffRequest;
use App\Models\MemberOfStaff;
use App\Repository\MemberOfStaffRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
    public function execute(MemberOfStaffRequest $request, MemberOfStaff $memberOfStaff): ?MemberOfStaff
    {
        return DB::transaction(function () use ($request, $memberOfStaff) {
            $memberOfStaff->first_name = Str::title($request->string('first_name')->value());
            $memberOfStaff->last_name = Str::title($request->string('last_name')->value());
            $memberOfStaff->user_id = $request->user()->id;

            return $this->memberOfStaffRepository->save($memberOfStaff);
        });
    }
}
