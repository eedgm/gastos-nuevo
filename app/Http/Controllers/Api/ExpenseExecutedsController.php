<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExecutedResource;
use App\Http\Resources\ExecutedCollection;

class ExpenseExecutedsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Expense $expense)
    {
        $this->authorize('view', $expense);

        $search = $request->get('search', '');

        $executeds = $expense
            ->executeds()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExecutedCollection($executeds);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Expense $expense)
    {
        $this->authorize('create', Executed::class);

        $validated = $request->validate([
            'cost' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'type_id' => ['required', 'exists:types,id'],
        ]);

        $executed = $expense->executeds()->create($validated);

        return new ExecutedResource($executed);
    }
}
