<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Assign;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the assign can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list assigns');
    }

    /**
     * Determine whether the assign can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Assign  $model
     * @return mixed
     */
    public function view(User $user, Assign $model)
    {
        return $user->hasPermissionTo('view assigns');
    }

    /**
     * Determine whether the assign can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create assigns');
    }

    /**
     * Determine whether the assign can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Assign  $model
     * @return mixed
     */
    public function update(User $user, Assign $model)
    {
        return $user->hasPermissionTo('update assigns');
    }

    /**
     * Determine whether the assign can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Assign  $model
     * @return mixed
     */
    public function delete(User $user, Assign $model)
    {
        return $user->hasPermissionTo('delete assigns');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Assign  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete assigns');
    }

    /**
     * Determine whether the assign can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Assign  $model
     * @return mixed
     */
    public function restore(User $user, Assign $model)
    {
        return false;
    }

    /**
     * Determine whether the assign can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Assign  $model
     * @return mixed
     */
    public function forceDelete(User $user, Assign $model)
    {
        return false;
    }
}
