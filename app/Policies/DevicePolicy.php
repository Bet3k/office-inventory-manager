<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any devices.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-device');
    }

    /**
     * Determine whether the user can view the device.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('view-device');
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create-device');
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('update-device');
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('delete-device');
    }
}
