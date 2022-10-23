<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Expense;
use App\Models\Executed;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.executeds.index', compact('executeds', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Executed::class);

        $expenses = Expense::pluck('date_to', 'id');
        $types = Type::pluck('name', 'id');

        return view('app.executeds.create', compact('expenses', 'types'));
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

        return redirect()
            ->route('executeds.edit', $executed)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Executed $executed
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Executed $executed)
    {
        $this->authorize('view', $executed);

        return view('app.executeds.show', compact('executed'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Executed $executed
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Executed $executed)
    {
        $this->authorize('update', $executed);

        $expenses = Expense::pluck('date_to', 'id');
        $types = Type::pluck('name', 'id');

        return view(
            'app.executeds.edit',
            compact('executed', 'expenses', 'types')
        );
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

        return redirect()
            ->route('executeds.edit', $executed)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('executeds.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
