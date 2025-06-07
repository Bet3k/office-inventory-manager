<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /*public function create(User $user): bool
    {
        return in_array($user->role, [
            'superadmin',
            'support',
            'admin',
            'headteacher',
        ]);
    }*/
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
