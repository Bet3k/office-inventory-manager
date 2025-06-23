<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeviceStaffMappingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any device staff mappings.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * Determine whether the user can view the device staff mapping.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * Determine whether the user can create device staff mappings.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * Determine whether the user can update the device staff mapping.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * Determine whether the user can delete the device staff mapping.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->is_active;
    }
}
