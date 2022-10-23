<?php

namespace App\Http\Controllers\Api;

use App\Models\Cluster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClusterResource;
use App\Http\Resources\ClusterCollection;
use App\Http\Requests\ClusterStoreRequest;
use App\Http\Requests\ClusterUpdateRequest;

class ClusterController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Cluster::class);

        $search = $request->get('search', '');

        $clusters = Cluster::search($search)
            ->latest()
            ->paginate();

        return new ClusterCollection($clusters);
    }

    /**
     * @param \App\Http\Requests\ClusterStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClusterStoreRequest $request)
    {
        $this->authorize('create', Cluster::class);

        $validated = $request->validated();

        $cluster = Cluster::create($validated);

        return new ClusterResource($cluster);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Cluster $cluster)
    {
        $this->authorize('view', $cluster);

        return new ClusterResource($cluster);
    }

    /**
     * @param \App\Http\Requests\ClusterUpdateRequest $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function update(ClusterUpdateRequest $request, Cluster $cluster)
    {
        $this->authorize('update', $cluster);

        $validated = $request->validated();

        $cluster->update($validated);

        return new ClusterResource($cluster);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cluster $cluster)
    {
        $this->authorize('delete', $cluster);

        $cluster->delete();

        return response()->noContent();
    }
}
