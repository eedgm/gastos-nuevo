<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class AccountExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Account $account)
    {
        $this->authorize('view', $account);

        $search = $request->get('search', '');

        $expenses = $account
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'date_to' => ['nullable', 'date'],
            'description' => ['nullable', 'max:255', 'string'],
            'cluster_id' => ['required', 'exists:clusters,id'],
            'assign_id' => ['required', 'exists:assigns,id'],
            'budget' => ['required', 'numeric'],
        ]);

        $expense = $account->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
