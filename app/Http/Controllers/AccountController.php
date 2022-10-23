<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;

class AccountController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Account::class);

        $search = $request->get('search', '');

        $user = Auth::user();

        $accounts = Account::join('account_user', 'accounts.id', '=', 'account_user.account_id')->where('account_user.user_id', $user->id)->search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.accounts.index', compact('accounts', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Account::class);

        $banks = Bank::pluck('name', 'id');

        return view('app.accounts.create', compact('banks'));
    }

    /**
     * @param \App\Http\Requests\AccountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountStoreRequest $request)
    {
        $this->authorize('create', Account::class);

        $user = Auth::user();

        $validated = $request->validated();

        $account = Account::create($validated);

        $account->users()->attach($user->id, []);

        return redirect()
            ->route('accounts.edit', $account)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Account $account)
    {
        $this->authorize('view', $account);

        return view('app.accounts.show', compact('account'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $banks = Bank::pluck('name', 'id');

        return view('app.accounts.edit', compact('account', 'banks'));
    }

    /**
     * @param \App\Http\Requests\AccountUpdateRequest $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function update(AccountUpdateRequest $request, Account $account)
    {
        $this->authorize('update', $account);

        $validated = $request->validated();

        $account->update($validated);

        return redirect()
            ->route('accounts.edit', $account)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Account $account)
    {
        $this->authorize('delete', $account);

        $account->delete();

        return redirect()
            ->route('accounts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
