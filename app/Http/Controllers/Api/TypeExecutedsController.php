<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExecutedResource;
use App\Http\Resources\ExecutedCollection;

class TypeExecutedsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Type $type)
    {
        $this->authorize('view', $type);

        $search = $request->get('search', '');

        $executeds = $type
            ->executeds()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExecutedCollection($executeds);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Type $type)
    {
        $this->authorize('create', Executed::class);

        $validated = $request->validate([
            'cost' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'expense_id' => ['required', 'exists:expenses,id'],
        ]);

        $executed = $type->executeds()->create($validated);

        return new ExecutedResource($executed);
    }
}
