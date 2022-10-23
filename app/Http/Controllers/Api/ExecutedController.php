<?php

namespace App\Http\Controllers\Api;

use App\Models\Executed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExecutedResource;
use App\Http\Resources\ExecutedCollection;
use App\Http\Requests\ExecutedStoreRequest;
use App\Http\Requests\ExecutedUpdateRequest;

class ExecutedController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Executed::class);

        $search = $request->get('search', '');

        $executeds = Executed::search($search)
            ->latest()
            ->paginate();

        return new ExecutedCollection($executeds);
    }

    /**
     * @param \App\Http\Requests\ExecutedStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExecutedStoreRequest $request)
    {
        $this->authorize('create', Executed::class);

        $validated = $request->validated();

        $executed = Executed::create($validated);

        return new ExecutedResource($executed);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Executed $executed
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Executed $executed)
    {
        $this->authorize('view', $executed);

        return new ExecutedResource($executed);
    }

    /**
     * @param \App\Http\Requests\ExecutedUpdateRequest $request
     * @param \App\Models\Executed $executed
     * @return \Illuminate\Http\Response
     */
    public function update(ExecutedUpdateRequest $request, Executed $executed)
    {
        $this->authorize('update', $executed);

        $validated = $request->validated();

        $executed->update($validated);

        return new ExecutedResource($executed);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Executed $executed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Executed $executed)
    {
        $this->authorize('delete', $executed);

        $executed->delete();

        return response()->noContent();
    }
}
