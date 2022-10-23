<?php

namespace App\Policies;

use App\Models\Type;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the type can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list types');
    }

    /**
     * Determine whether the type can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Type  $model
     * @return mixed
     */
    public function view(User $user, Type $model)
    {
        return $user->hasPermissionTo('view types');
    }

    /**
     * Determine whether the type can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create types');
    }

    /**
     * Determine whether the type can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Type  $model
     * @return mixed
     */
    public function update(User $user, Type $model)
    {
        return $user->hasPermissionTo('update types');
    }

    /**
     * Determine whether the type can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Type  $model
     * @return mixed
     */
    public function delete(User $user, Type $model)
    {
        return $user->hasPermissionTo('delete types');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Type  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete types');
    }

    /**
     * Determine whether the type can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Type  $model
     * @return mixed
     */
    public function restore(User $user, Type $model)
    {
        return false;
    }

    /**
     * Determine whether the type can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Type  $model
     * @return mixed
     */
    public function forceDelete(User $user, Type $model)
    {
        return false;
    }
}
