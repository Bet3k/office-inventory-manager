<?php

namespace App\Actions\Department;

use App\Models\Department;
use App\Repository\DepartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListDepartmentAction
{
    private DepartmentRepository $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, Department>
     */
    public function execute(Request $request): LengthAwarePaginator
    {
        return $this->departmentRepository->all($request);
    }
}
