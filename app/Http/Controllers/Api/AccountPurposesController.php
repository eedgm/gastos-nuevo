<?php
namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Purpose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurposeCollection;

class AccountPurposesController extends Controller
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

        $purposes = $account
            ->purposes()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurposeCollection($purposes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account, Purpose $purpose)
    {
        $this->authorize('update', $account);

        $account->purposes()->syncWithoutDetaching([$purpose->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Account $account,
        Purpose $purpose
    ) {
        $this->authorize('update', $account);

        $account->purposes()->detach($purpose);

        return response()->noContent();
    }
}
