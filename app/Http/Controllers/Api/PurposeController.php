<?php

namespace App\Http\Controllers\Api;

use App\Models\Purpose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurposeResource;
use App\Http\Resources\PurposeCollection;
use App\Http\Requests\PurposeStoreRequest;
use App\Http\Requests\PurposeUpdateRequest;

class PurposeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Purpose::class);

        $search = $request->get('search', '');

        $purposes = Purpose::search($search)
            ->latest()
            ->paginate();

        return new PurposeCollection($purposes);
    }

    /**
     * @param \App\Http\Requests\PurposeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurposeStoreRequest $request)
    {
        $this->authorize('create', Purpose::class);

        $validated = $request->validated();

        $purpose = Purpose::create($validated);

        return new PurposeResource($purpose);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Purpose $purpose)
    {
        $this->authorize('view', $purpose);

        return new PurposeResource($purpose);
    }

    /**
     * @param \App\Http\Requests\PurposeUpdateRequest $request
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function update(PurposeUpdateRequest $request, Purpose $purpose)
    {
        $this->authorize('update', $purpose);

        $validated = $request->validated();

        $purpose->update($validated);

        return new PurposeResource($purpose);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Purpose $purpose)
    {
        $this->authorize('delete', $purpose);

        $purpose->delete();

        return response()->noContent();
    }
}
