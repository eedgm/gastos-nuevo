<?php

namespace App\Http\Controllers\Api;

use App\Models\Assign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class AssignExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Assign $assign)
    {
        $this->authorize('view', $assign);

        $search = $request->get('search', '');

        $expenses = $assign
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assign $assign
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Assign $assign)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'date_to' => ['nullable', 'date'],
            'description' => ['nullable', 'max:255', 'string'],
            'cluster_id' => ['required', 'exists:clusters,id'],
            'budget' => ['required', 'numeric'],
        ]);

        $expense = $assign->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
