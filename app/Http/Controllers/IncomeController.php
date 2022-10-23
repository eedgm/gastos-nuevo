<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Requests\IncomeStoreRequest;
use App\Http\Requests\IncomeUpdateRequest;

class IncomeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Income::class);

        $search = $request->get('search', '');

        $incomes = Income::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.incomes.index', compact('incomes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Income::class);

        $accounts = Account::pluck('name', 'id');

        return view('app.incomes.create', compact('accounts'));
    }

    /**
     * @param \App\Http\Requests\IncomeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomeStoreRequest $request)
    {
        $this->authorize('create', Income::class);

        $validated = $request->validated();

        $income = Income::create($validated);

        return redirect()
            ->route('incomes.edit', $income)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Income $income)
    {
        $this->authorize('view', $income);

        return view('app.incomes.show', compact('income'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Income $income)
    {
        $this->authorize('update', $income);

        $accounts = Account::pluck('name', 'id');

        return view('app.incomes.edit', compact('income', 'accounts'));
    }

    /**
     * @param \App\Http\Requests\IncomeUpdateRequest $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function update(IncomeUpdateRequest $request, Income $income)
    {
        $this->authorize('update', $income);

        $validated = $request->validated();

        $income->update($validated);

        return redirect()
            ->route('incomes.edit', $income)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Income $income)
    {
        $this->authorize('delete', $income);

        $income->delete();

        return redirect()
            ->route('incomes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
