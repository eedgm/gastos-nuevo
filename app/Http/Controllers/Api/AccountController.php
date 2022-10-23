<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountCollection;
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

        $accounts = Account::search($search)
            ->latest()
            ->paginate();

        return new AccountCollection($accounts);
    }

    /**
     * @param \App\Http\Requests\AccountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountStoreRequest $request)
    {
        $this->authorize('create', Account::class);

        $validated = $request->validated();

        $account = Account::create($validated);

        return new AccountResource($account);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Account $account)
    {
        $this->authorize('view', $account);

        return new AccountResource($account);
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

        return new AccountResource($account);
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

        return response()->noContent();
    }
}
