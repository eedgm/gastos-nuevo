<?php
namespace App\Http\Controllers\Api;

use App\Models\Purpose;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCollection;

class PurposeAccountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Purpose $purpose)
    {
        $this->authorize('view', $purpose);

        $search = $request->get('search', '');

        $accounts = $purpose
            ->accounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCollection($accounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Purpose $purpose, Account $account)
    {
        $this->authorize('update', $purpose);

        $purpose->accounts()->syncWithoutDetaching([$account->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Purpose $purpose,
        Account $account
    ) {
        $this->authorize('update', $purpose);

        $purpose->accounts()->detach($account);

        return response()->noContent();
    }
}
