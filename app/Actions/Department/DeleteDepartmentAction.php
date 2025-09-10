<?php

namespace App\Actions\Department;

use App\Models\Department;
use App\Repository\DepartmentRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteDepartmentAction
{
    private DepartmentRepository $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(Department $department): ?bool
    {
        return DB::transaction(function () use ($department) {
            return $this->departmentRepository->delete($department);
        });
    }
}
