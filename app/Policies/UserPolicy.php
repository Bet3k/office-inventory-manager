<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('viewAny-user');
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->can('view-user');
    }

    public function create(User $user): bool
    {
        return $user->can('create-user');
    }
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->can('update-user');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->can('delete-user');
    }
}
