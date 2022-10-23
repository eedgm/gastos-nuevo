<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.assigns.index', compact('assigns', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Assign::class);

        return view('app.assigns.create');
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

        return redirect()
            ->route('assigns.edit', $assign)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Assign $assign)
    {
        $this->authorize('view', $assign);

        return view('app.assigns.show', compact('assign'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Assign $assign)
    {
        $this->authorize('update', $assign);

        return view('app.assigns.edit', compact('assign'));
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

        return redirect()
            ->route('assigns.edit', $assign)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('assigns.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
