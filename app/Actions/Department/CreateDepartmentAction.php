<?php

namespace App\Actions\Department;

use App\Dtos\DepartmentDto;
use App\Models\Department;
use App\Models\User;
use App\Repository\DepartmentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateDepartmentAction
{
    private DepartmentRepository $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(DepartmentDto $dto): ?Department
    {
        return DB::transaction(function () use ($dto) {
            /** @var User $user */
            $user = Auth::user();

            $pdp = new Department();
            $pdp->department = $dto->department;
            $pdp->user_id = $user->id;

            return $this->departmentRepository->save($pdp);
        });
    }
}
