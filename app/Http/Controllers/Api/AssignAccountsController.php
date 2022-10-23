<?php
namespace App\Http\Controllers\Api;

use App\Models\Assign;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCollection;

class AssignAccountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Assign $assign)
    {
        $this->authorize('view', $assign);

        $search = $request->get('search', '');

        $accounts = $assign
            ->accounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCollection($accounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Assign $assign, Account $account)
    {
        $this->authorize('update', $assign);

        $assign->accounts()->syncWithoutDetaching([$account->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Assign $assign, Account $account)
    {
        $this->authorize('update', $assign);

        $assign->accounts()->detach($account);

        return response()->noContent();
    }
}
