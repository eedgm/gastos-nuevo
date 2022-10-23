<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the expense can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list expenses');
    }

    /**
     * Determine whether the expense can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Expense  $model
     * @return mixed
     */
    public function view(User $user, Expense $model)
    {
        return $user->hasPermissionTo('view expenses');
    }

    /**
     * Determine whether the expense can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create expenses');
    }

    /**
     * Determine whether the expense can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Expense  $model
     * @return mixed
     */
    public function update(User $user, Expense $model)
    {
        return $user->hasPermissionTo('update expenses');
    }

    /**
     * Determine whether the expense can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Expense  $model
     * @return mixed
     */
    public function delete(User $user, Expense $model)
    {
        return $user->hasPermissionTo('delete expenses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Expense  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete expenses');
    }

    /**
     * Determine whether the expense can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Expense  $model
     * @return mixed
     */
    public function restore(User $user, Expense $model)
    {
        return false;
    }

    /**
     * Determine whether the expense can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Expense  $model
     * @return mixed
     */
    public function forceDelete(User $user, Expense $model)
    {
        return false;
    }
}
