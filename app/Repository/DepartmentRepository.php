<?php

namespace App\Repository;

use App\Models\Department;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class DepartmentRepository
{
    /**
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, Department>
     */
    public function all(Request $request): LengthAwarePaginator
    {
        return Department::query()
            ->when(
                $request->filled('search'),
                fn ($q) => $q->where('department', 'like', '%' . $request->string('search')->value() . '%')
            )
            ->orderBy(
                $request->input('sort_field') === 'department'
                    ? $request->string('sort_field')->value()
                    : 'created_at',
                in_array($request->input('sort_order'), ['asc', 'desc'], true)
                    ? $request->string('sort_order')->value()
                    : 'desc'
            )
            ->paginate(
                $request->filled('per_page')
                    ? $request->integer('per_page')
                    : 15
            )
            ->withQueryString();
    }

    /**
     * @param  Department  $department
     *
     * @return Department
     */
    public function save(Department $department): Department
    {
        $department->save();

        return $department->refresh();
    }

    /**
     * @param  Department  $department
     *
     * @return bool|null
     *
     * @throws Exception
     */
    public function delete(Department $department): ?bool
    {
        return $department->delete();
    }
}
