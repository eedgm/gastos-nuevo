<?php

namespace App\Http\Controllers\Api;

use App\Models\Cluster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class ClusterExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Cluster $cluster)
    {
        $this->authorize('view', $cluster);

        $search = $request->get('search', '');

        $expenses = $cluster
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cluster $cluster
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cluster $cluster)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'date_to' => ['nullable', 'date'],
            'description' => ['nullable', 'max:255', 'string'],
            'assign_id' => ['required', 'exists:assigns,id'],
            'budget' => ['required', 'numeric'],
        ]);

        $expense = $cluster->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
