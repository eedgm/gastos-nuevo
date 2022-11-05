<?php

namespace App\Policies;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BalancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list balances');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Balance $balance)
    {
        return $user->hasPermissionTo('view balances');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $user->hasPermissionTo('create balances');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Balance $balance)
    {
        return $user->hasPermissionTo('update balances');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Balance $balance)
    {
        return $user->hasPermissionTo('delete balances');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Balance  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete balances');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Balance $balance)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Balance $balance)
    {
        return false;
    }
}
