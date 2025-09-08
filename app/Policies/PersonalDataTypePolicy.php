<?php

namespace App\Policies;

use App\Models\PersonalDataType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonalDataTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-personal-data-type');
    }

    public function view(User $user): bool
    {
        return $user->can('view-personal-data-type');
    }

    public function create(User $user): bool
    {
        return $user->can('create-personal-data-type');
    }

    public function update(User $user): bool
    {
        return $user->can('update-personal-data-type');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete-personal-data-type');
    }
}
