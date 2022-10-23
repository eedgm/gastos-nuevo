<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Income;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the income can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list incomes');
    }

    /**
     * Determine whether the income can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Income  $model
     * @return mixed
     */
    public function view(User $user, Income $model)
    {
        return $user->hasPermissionTo('view incomes');
    }

    /**
     * Determine whether the income can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create incomes');
    }

    /**
     * Determine whether the income can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Income  $model
     * @return mixed
     */
    public function update(User $user, Income $model)
    {
        return $user->hasPermissionTo('update incomes');
    }

    /**
     * Determine whether the income can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Income  $model
     * @return mixed
     */
    public function delete(User $user, Income $model)
    {
        return $user->hasPermissionTo('delete incomes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Income  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete incomes');
    }

    /**
     * Determine whether the income can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Income  $model
     * @return mixed
     */
    public function restore(User $user, Income $model)
    {
        return false;
    }

    /**
     * Determine whether the income can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Income  $model
     * @return mixed
     */
    public function forceDelete(User $user, Income $model)
    {
        return false;
    }
}
