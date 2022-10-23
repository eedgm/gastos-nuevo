<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.clusters.index', compact('clusters', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Cluster::class);

        return view('app.clusters.create');
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

        return redirect()
            ->route('clusters.edit', $cluster)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Cluster $cluster)
    {
        $this->authorize('view', $cluster);

        return view('app.clusters.show', compact('cluster'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Cluster $cluster)
    {
        $this->authorize('update', $cluster);

        return view('app.clusters.edit', compact('cluster'));
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

        return redirect()
            ->route('clusters.edit', $cluster)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('clusters.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
