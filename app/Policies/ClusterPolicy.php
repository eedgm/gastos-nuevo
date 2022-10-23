<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cluster;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClusterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cluster can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list clusters');
    }

    /**
     * Determine whether the cluster can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cluster  $model
     * @return mixed
     */
    public function view(User $user, Cluster $model)
    {
        return $user->hasPermissionTo('view clusters');
    }

    /**
     * Determine whether the cluster can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create clusters');
    }

    /**
     * Determine whether the cluster can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cluster  $model
     * @return mixed
     */
    public function update(User $user, Cluster $model)
    {
        return $user->hasPermissionTo('update clusters');
    }

    /**
     * Determine whether the cluster can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cluster  $model
     * @return mixed
     */
    public function delete(User $user, Cluster $model)
    {
        return $user->hasPermissionTo('delete clusters');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cluster  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete clusters');
    }

    /**
     * Determine whether the cluster can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cluster  $model
     * @return mixed
     */
    public function restore(User $user, Cluster $model)
    {
        return false;
    }

    /**
     * Determine whether the cluster can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cluster  $model
     * @return mixed
     */
    public function forceDelete(User $user, Cluster $model)
    {
        return false;
    }
}
