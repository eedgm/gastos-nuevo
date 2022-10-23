<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Requests\TypeStoreRequest;
use App\Http\Requests\TypeUpdateRequest;

class TypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Type::class);

        $search = $request->get('search', '');

        $types = Type::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.types.index', compact('types', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Type::class);

        return view('app.types.create');
    }

    /**
     * @param \App\Http\Requests\TypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeStoreRequest $request)
    {
        $this->authorize('create', Type::class);

        $validated = $request->validated();

        $type = Type::create($validated);

        return redirect()
            ->route('types.edit', $type)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Type $type)
    {
        $this->authorize('view', $type);

        return view('app.types.show', compact('type'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Type $type)
    {
        $this->authorize('update', $type);

        return view('app.types.edit', compact('type'));
    }

    /**
     * @param \App\Http\Requests\TypeUpdateRequest $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function update(TypeUpdateRequest $request, Type $type)
    {
        $this->authorize('update', $type);

        $validated = $request->validated();

        $type->update($validated);

        return redirect()
            ->route('types.edit', $type)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Type $type)
    {
        $this->authorize('delete', $type);

        $type->delete();

        return redirect()
            ->route('types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
