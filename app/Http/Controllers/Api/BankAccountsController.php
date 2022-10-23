<?php

namespace App\Http\Controllers\Api;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountCollection;

class BankAccountsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Bank $bank)
    {
        $this->authorize('view', $bank);

        $search = $request->get('search', '');

        $accounts = $bank
            ->accounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCollection($accounts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Bank $bank)
    {
        $this->authorize('create', Account::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'number' => ['required', 'max:255', 'string'],
            'type' => ['required', 'in:Ahorro,Corriente'],
            'owner' => ['nullable', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
        ]);

        $account = $bank->accounts()->create($validated);

        return new AccountResource($account);
    }
}
