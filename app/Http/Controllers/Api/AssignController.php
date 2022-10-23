<?php

namespace App\Http\Controllers\Api;

use App\Models\Assign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssignResource;
use App\Http\Resources\AssignCollection;
use App\Http\Requests\AssignStoreRequest;
use App\Http\Requests\AssignUpdateRequest;

class AssignController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Assign::class);

        $search = $request->get('search', '');

        $assigns = Assign::search($search)
            ->latest()
            ->paginate();

        return new AssignCollection($assigns);
    }

    /**
     * @param \App\Http\Requests\AssignStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignStoreRequest $request)
    {
        $this->authorize('create', Assign::class);

        $validated = $request->validated();

        $assign = Assign::create($validated);

        return new AssignResource($assign);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Assign $assign)
    {
        $this->authorize('view', $assign);

        return new AssignResource($assign);
    }

    /**
     * @param \App\Http\Requests\AssignUpdateRequest $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function update(AssignUpdateRequest $request, Assign $assign)
    {
        $this->authorize('update', $assign);

        $validated = $request->validated();

        $assign->update($validated);

        return new AssignResource($assign);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Assign $assign)
    {
        $this->authorize('delete', $assign);

        $assign->delete();

        return response()->noContent();
    }
}
