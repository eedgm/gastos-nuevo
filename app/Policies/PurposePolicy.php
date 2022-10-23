<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Purpose;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurposePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purpose can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list purposes');
    }

    /**
     * Determine whether the purpose can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Purpose  $model
     * @return mixed
     */
    public function view(User $user, Purpose $model)
    {
        return $user->hasPermissionTo('view purposes');
    }

    /**
     * Determine whether the purpose can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create purposes');
    }

    /**
     * Determine whether the purpose can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Purpose  $model
     * @return mixed
     */
    public function update(User $user, Purpose $model)
    {
        return $user->hasPermissionTo('update purposes');
    }

    /**
     * Determine whether the purpose can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Purpose  $model
     * @return mixed
     */
    public function delete(User $user, Purpose $model)
    {
        return $user->hasPermissionTo('delete purposes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Purpose  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete purposes');
    }

    /**
     * Determine whether the purpose can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Purpose  $model
     * @return mixed
     */
    public function restore(User $user, Purpose $model)
    {
        return false;
    }

    /**
     * Determine whether the purpose can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Purpose  $model
     * @return mixed
     */
    public function forceDelete(User $user, Purpose $model)
    {
        return false;
    }
}
