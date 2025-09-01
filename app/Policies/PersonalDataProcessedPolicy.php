<?php

namespace App\Policies;

use App\Models\PersonalDataProcessed;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonalDataProcessedPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-personal-data-processed');
    }

    public function view(User $user): bool
    {
        return $user->can('view-personal-data-processed');
    }

    public function create(User $user): bool
    {
        return $user->can('create-personal-data-processed');
    }

    public function update(User $user): bool
    {
        return $user->can('update-personal-data-processed');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete-personal-data-processed');
    }
}
