<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\IncomeCollection;

class AccountIncomesController extends Controller
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

        $incomes = $account
            ->incomes()
            ->search($search)
            ->latest()
            ->paginate();

        return new IncomeCollection($incomes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account)
    {
        $this->authorize('create', Income::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'cost' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
        ]);

        $income = $account->incomes()->create($validated);

        return new IncomeResource($income);
    }
}
