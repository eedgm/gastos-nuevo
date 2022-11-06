<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Assign;
use App\Models\Account;
use App\Models\Cluster;
use App\Models\Expense;
use App\Models\Purpose;
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

        $user_obj = Auth::user();
        $user_id = $user_obj->id;

        return view('app.expenses.home', compact('types', 'user_id'));
    }

    public function search(Request $request) {
        $user = Auth::user();

        if ($request->account_id) {
            $account = $request->account_id;
            $results = Expense::orderBy('date', 'DESC')
                ->where('account_id', $account)
                ->where('date', '>=', $request->desde)
                ->where('date', '<=', $request->hasta)
                ->get();
        } else {
            $accounts = $user->accounts->modelKeys();

            $results = Expense::orderBy('date', 'DESC')
                ->whereIn('account_id', $accounts)
                ->where('date', '>=', $request->desde)
                ->where('date', '<=', $request->hasta)
                ->get();
        }

        $clusters = Cluster::join('account_cluster', 'clusters.id', '=', 'account_cluster.account_id')
            ->join('accounts', 'account_cluster.account_id', '=', 'accounts.id')
            ->join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user->id)
            ->pluck('clusters.name', 'clusters.id');

        $assigns = Assign::join('account_assign', 'assigns.id', '=', 'account_assign.assign_id')
            ->join('accounts', 'account_assign.account_id', '=', 'accounts.id')
            ->join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user->id)
            ->pluck('assigns.name', 'assigns.id');

        $purposes = Purpose::join('account_purpose', 'purposes.id', '=', 'account_purpose.purpose_id')
            ->join('accounts', 'account_purpose.account_id', '=', 'accounts.id')
            ->join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user->id)
            ->pluck('purposes.name', 'purposes.id');

        $types = Type::pluck('name', 'id');

        $accounts = Account::join('account_user', 'account_user.account_id', '=', 'accounts.id')
            ->where('account_user.user_id', $user->id)
            ->pluck('accounts.name', 'accounts.id');

        $expenses = [];

        foreach($results as $result) {
            $expenses['events'][$result->id]['id'] = $result->id;
            $expenses['events'][$result->id]['account_name'] = $result->account->name ?? '-';
            $expenses['events'][$result->id]['date'] = $result->date ? $result->date->format('m/d/y') : '-';
            $expenses['events'][$result->id]['date_to'] = $result->date_to ? $result->date_to->format('m/d/y') : '-';
            $expenses['events'][$result->id]['description'] = $result->description ?? '-';
            $expenses['events'][$result->id]['cluster_name'] = $result->cluster->name ?? '-';
            $expenses['events'][$result->id]['user_name'] = $result->user->name ?? '-';
            $expenses['events'][$result->id]['assign_name'] = $result->assign->name ?? '-';
            $expenses['events'][$result->id]['budget'] = $result->budget ?? '-';
            $expenses['events'][$result->id]['cluster'] = $result->cluster_id;
            $expenses['events'][$result->id]['assign'] = $result->assign_id;
            $expenses['events'][$result->id]['account'] = $result->account_id;
            $expenses['events'][$result->id]['user'] = $result->user_id;

            if ($result->purposes) {
                foreach($result->purposes as $purpose) {
                    $expenses['events'][$result->id]['purpose'] = $purpose->color->color;
                    $expenses['events'][$result->id]['purpose_id'] = $purpose->id;
                }
            } else {
                $expenses['events'][$result->id]['purpose'] = 'border-blue-200 text-blue-800 bg-blue-100';
            }
            $total = 0;
            foreach ($result->executeds as $executed) {
                $expenses['events'][$result->id]['executed'][$executed->type->object_name] = isset($expenses['events'][$result->id]['executed'][$executed->type->object_name]) ? number_format($expenses['events'][$result->id]['executed'][$executed->type->object_name] + $executed->cost, 2) : number_format($executed->cost, 2);
                $total += $executed->cost;
            }
            $expenses['events'][$result->id]['total'] = $total;

        }

        $colors = [];
        $purposes_colors = Purpose::get();
        foreach ($purposes_colors as $p) {
            $colors[$p->id] = $p->color->color;
        }

        $expenses['clusters'] = $clusters;
        $expenses['assigns'] = $assigns;
        $expenses['purposes'] = $purposes;
        $expenses['colors'] = $colors;
        $expenses['types'] = $types;
        $expenses['accounts'] = $accounts;

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
