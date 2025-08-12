<?php

namespace App\Policies;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionnairePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any questionnaires.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the questionnaire.
     *
     * @param  User  $user
     * @param  Questionnaire  $questionnaire
     * @return bool
     */
    public function view(User $user, Questionnaire $questionnaire): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create questionnaires.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the questionnaire.
     *
     * @param  User  $user
     * @param  Questionnaire  $questionnaire
     * @return bool
     */
    public function update(User $user, Questionnaire $questionnaire): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the questionnaire.
     *
     * @param  User  $user
     * @param  Questionnaire  $questionnaire
     * @return bool
     */
    public function delete(User $user, Questionnaire $questionnaire): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the questionnaire.
     *
     * @param  User  $user
     * @param  Questionnaire  $questionnaire
     * @return bool
     */
    public function restore(User $user, Questionnaire $questionnaire): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the questionnaire.
     *
     * @param  User  $user
     * @param  Questionnaire  $questionnaire
     * @return bool
     */
    public function forceDelete(User $user, Questionnaire $questionnaire): bool
    {
        return true;
    }
}
