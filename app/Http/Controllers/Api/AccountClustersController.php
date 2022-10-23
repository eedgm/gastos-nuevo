<?php
namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Cluster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClusterCollection;

class AccountClustersController extends Controller
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

        $clusters = $account
            ->clusters()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClusterCollection($clusters);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account, Cluster $cluster)
    {
        $this->authorize('update', $account);

        $account->clusters()->syncWithoutDetaching([$cluster->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Account $account,
        Cluster $cluster
    ) {
        $this->authorize('update', $account);

        $account->clusters()->detach($cluster);

        return response()->noContent();
    }
}
