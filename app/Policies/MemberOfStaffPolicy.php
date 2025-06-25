<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberOfStaffPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-member_of_staff');
    }

    public function view(User $user): bool
    {
        return $user->can('view-member_of_staff');
    }

    public function create(User $user): bool
    {
        return $user->can('create-member_of_staff');
    }

    public function update(User $user): bool
    {
        return $user->can('update-member_of_staff');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete-member_of_staff');
    }
}
