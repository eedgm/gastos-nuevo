<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Resources\TypeResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TypeCollection;
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
            ->paginate();

        return new TypeCollection($types);
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

        return new TypeResource($type);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Type $type)
    {
        $this->authorize('view', $type);

        return new TypeResource($type);
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

        return new TypeResource($type);
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

        return response()->noContent();
    }
}
