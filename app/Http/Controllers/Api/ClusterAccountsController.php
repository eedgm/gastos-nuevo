<?php
namespace App\Http\Controllers\Api;

use App\Models\Cluster;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCollection;

class ClusterAccountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Cluster $cluster)
    {
        $this->authorize('view', $cluster);

        $search = $request->get('search', '');

        $accounts = $cluster
            ->accounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCollection($accounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cluster $cluster, Account $account)
    {
        $this->authorize('update', $cluster);

        $cluster->accounts()->syncWithoutDetaching([$account->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Cluster $cluster,
        Account $account
    ) {
        $this->authorize('update', $cluster);

        $cluster->accounts()->detach($account);

        return response()->noContent();
    }
}
