<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SoftwarePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any software.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-software');
    }

    /**
     * Determine whether the user can view the software.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('view-software');
    }

    /**
     * Determine whether the user can create software.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create-software');
    }

    /**
     * Determine whether the user can update the software.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('update-software');
    }

    /**
     * Determine whether the user can delete the software.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('delete-software');
    }
}
