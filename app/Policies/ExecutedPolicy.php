<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Executed;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExecutedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the executed can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list executeds');
    }

    /**
     * Determine whether the executed can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Executed  $model
     * @return mixed
     */
    public function view(User $user, Executed $model)
    {
        return $user->hasPermissionTo('view executeds');
    }

    /**
     * Determine whether the executed can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create executeds');
    }

    /**
     * Determine whether the executed can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Executed  $model
     * @return mixed
     */
    public function update(User $user, Executed $model)
    {
        return $user->hasPermissionTo('update executeds');
    }

    /**
     * Determine whether the executed can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Executed  $model
     * @return mixed
     */
    public function delete(User $user, Executed $model)
    {
        return $user->hasPermissionTo('delete executeds');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Executed  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete executeds');
    }

    /**
     * Determine whether the executed can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Executed  $model
     * @return mixed
     */
    public function restore(User $user, Executed $model)
    {
        return false;
    }

    /**
     * Determine whether the executed can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Executed  $model
     * @return mixed
     */
    public function forceDelete(User $user, Executed $model)
    {
        return false;
    }
}
