<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BalanceStoreRequest;
use App\Http\Requests\StoreBalanceRequest;
use App\Http\Requests\BalanceUpdateRequest;
use App\Http\Requests\UpdateBalanceRequest;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Balance::class);

        $user = Auth::user();
        $accounts = $user->accounts->modelKeys();

        $search = $request->get('search', '');

        $balances = Balance::search($search)
            ->whereIn('account_id', $accounts)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.balances.index', compact('balances', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Balance::class);

        $user = Auth::user();
        $accounts_to_select = $user->accounts->modelKeys();

        $accounts = Account::whereIn('id', $accounts_to_select)->pluck('name', 'id');

        return view('app.balances.create', compact('accounts'));
    }

    /**
     * @param \App\Http\Requests\BalanceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BalanceStoreRequest $request)
    {
        $this->authorize('create', Balance::class);

        $validated = $request->validated();

        $balance = Balance::create($validated);

        return redirect()
            ->route('balances.edit', $balance)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Balance $balance
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Balance $balance)
    {
        $this->authorize('view', $balance);

        return view('app.balances.show', compact('Balance'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Balance $balance
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Balance $balance)
    {
        $this->authorize('update', $balance);

        $accounts = Account::pluck('name', 'id');

        return view('app.balances.edit', compact('balance', 'accounts'));
    }

    /**
     * @param \App\Http\Requests\BalanceUpdateRequest $request
     * @param \App\Models\Balance $balance
     * @return \Illuminate\Http\Response
     */
    public function update(BalanceUpdateRequest $request, Balance $balance)
    {
        $this->authorize('update', $balance);

        $validated = $request->validated();

        $balance->update($validated);

        return redirect()
            ->route('balances.edit', $balance)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Balance $balance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Balance $balance)
    {
        $this->authorize('delete', $balance);

        $balance->delete();

        return redirect()
            ->route('balances.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
