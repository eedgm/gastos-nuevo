<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCollection;

class UserAccountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $accounts = $user
            ->accounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCollection($accounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Account $account)
    {
        $this->authorize('update', $user);

        $user->accounts()->syncWithoutDetaching([$account->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user, Account $account)
    {
        $this->authorize('update', $user);

        $user->accounts()->detach($account);

        return response()->noContent();
    }
}
