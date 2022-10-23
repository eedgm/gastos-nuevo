<?php
namespace App\Http\Controllers\Api;

use App\Models\Assign;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssignCollection;

class AccountAssignsController extends Controller
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

        $assigns = $account
            ->assigns()
            ->search($search)
            ->latest()
            ->paginate();

        return new AssignCollection($assigns);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account, Assign $assign)
    {
        $this->authorize('update', $account);

        $account->assigns()->syncWithoutDetaching([$assign->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Account $account, Assign $assign)
    {
        $this->authorize('update', $account);

        $account->assigns()->detach($assign);

        return response()->noContent();
    }
}
