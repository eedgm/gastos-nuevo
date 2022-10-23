<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Purpose;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.purposes.index', compact('purposes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Purpose::class);

        $colors = Color::pluck('name', 'id');

        return view('app.purposes.create', compact('colors'));
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

        return redirect()
            ->route('purposes.edit', $purpose)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Purpose $purpose)
    {
        $this->authorize('view', $purpose);

        return view('app.purposes.show', compact('purpose'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Purpose $purpose)
    {
        $this->authorize('update', $purpose);

        $colors = Color::pluck('name', 'id');

        return view('app.purposes.edit', compact('purpose', 'colors'));
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

        return redirect()
            ->route('purposes.edit', $purpose)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('purposes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
