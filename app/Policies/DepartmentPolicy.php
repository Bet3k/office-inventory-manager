<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-department');
    }

    public function view(User $user): bool
    {
        return $user->can('view-department');
    }

    public function create(User $user): bool
    {
        return $user->can('create-department');
    }

    public function update(User $user): bool
    {
        return $user->can('update-department');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete-department');
    }
}
