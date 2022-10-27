<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Assign;
use App\Models\Account;
use App\Models\Cluster;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;

class ExpenseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Expense::class);

        $search = $request->get('search', '');

        $expenses = Expense::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.expenses.index', compact('expenses', 'search'));
    }

    public function home(Request $request) {
        $types = Type::get();
        return view('app.expenses.home', compact('types'));
    }

    public function search(Request $request) {
        $user = Auth::user();
        $accounts = $user->accounts->modelKeys();

        $results = Expense::orderBy('date', 'DESC')
            ->whereIn('account_id', $accounts)
            ->where('date', '>=', $request->desde)
            ->where('date', '<=', $request->hasta)
            ->get();

        $expenses = [];

        foreach($results as $result) {
            $expenses[$result->id]['id'] = $result->id;
            $expenses[$result->id]['account'] = $result->account->name ?? '-';
            $expenses[$result->id]['date'] = $result->date ? $result->date->format('m/d/y') : '-';
            $expenses[$result->id]['date_to'] = $result->date_to ? $result->date_to->format('m/d/y') : '-';
            $expenses[$result->id]['description'] = $result->description ?? '-';
            $expenses[$result->id]['cluster'] = $result->cluster->name ?? '-';
            $expenses[$result->id]['user'] = $result->user->name ?? '-';
            $expenses[$result->id]['assign'] = $result->assign->name ?? '-';
            $expenses[$result->id]['budget'] = $result->budget ?? '-';
            $total = 0;
            foreach ($result->executeds as $executed) {
                $expenses[$result->id]['executed'][$executed->type->object_name] = isset($expenses[$result->id]['executed'][$executed->type->object_name]) ? $expenses[$result->id]['executed'][$executed->type->object_name] + $executed->cost : $executed->cost;
                $total += $executed->cost;
            }
            $expenses[$result->id]['total'] = $total;

        }

        return json_encode($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Expense::class);

        $clusters = Cluster::pluck('name', 'id');
        $assigns = Assign::pluck('name', 'id');
        $accounts = Account::pluck('name', 'id');

        return view(
            'app.expenses.create',
            compact('clusters', 'assigns', 'accounts')
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validated();

        $expense = Expense::create($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expense $expense)
    {
        $this->authorize('view', $expense);

        return view('app.expenses.show', compact('expense'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $clusters = Cluster::pluck('name', 'id');
        $assigns = Assign::pluck('name', 'id');
        $accounts = Account::pluck('name', 'id');

        return view(
            'app.expenses.edit',
            compact('expense', 'clusters', 'assigns', 'accounts')
        );
    }

    /**
     * @param \App\Http\Requests\ExpenseUpdateRequest $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseUpdateRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $validated = $request->validated();

        $expense->update($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Expense $expense)
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
