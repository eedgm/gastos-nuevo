<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the account can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list accounts');
    }

    /**
     * Determine whether the account can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Account  $model
     * @return mixed
     */
    public function view(User $user, Account $model)
    {
        return $user->hasPermissionTo('view accounts');
    }

    /**
     * Determine whether the account can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create accounts');
    }

    /**
     * Determine whether the account can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Account  $model
     * @return mixed
     */
    public function update(User $user, Account $model)
    {
        return $user->hasPermissionTo('update accounts');
    }

    /**
     * Determine whether the account can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Account  $model
     * @return mixed
     */
    public function delete(User $user, Account $model)
    {
        return $user->hasPermissionTo('delete accounts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Account  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete accounts');
    }

    /**
     * Determine whether the account can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Account  $model
     * @return mixed
     */
    public function restore(User $user, Account $model)
    {
        return false;
    }

    /**
     * Determine whether the account can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Account  $model
     * @return mixed
     */
    public function forceDelete(User $user, Account $model)
    {
        return false;
    }
}
