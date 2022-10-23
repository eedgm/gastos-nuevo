<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class AccountUsersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Account $account)
    {
        $this->authorize('view', $account);

        $search = $request->get('search', '');

        $users = $account
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account, User $user)
    {
        $this->authorize('update', $account);

        $account->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Account $account, User $user)
    {
        $this->authorize('update', $account);

        $account->users()->detach($user);

        return response()->noContent();
    }
}
