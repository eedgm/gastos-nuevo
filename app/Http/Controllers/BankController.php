<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;

class BankController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Bank::class);

        $search = $request->get('search', '');

        $banks = Bank::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.banks.index', compact('banks', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Bank::class);

        return view('app.banks.create');
    }

    /**
     * @param \App\Http\Requests\BankStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankStoreRequest $request)
    {
        $this->authorize('create', Bank::class);

        $validated = $request->validated();

        $bank = Bank::create($validated);

        return redirect()
            ->route('banks.edit', $bank)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Bank $bank)
    {
        $this->authorize('view', $bank);

        return view('app.banks.show', compact('bank'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Bank $bank)
    {
        $this->authorize('update', $bank);

        return view('app.banks.edit', compact('bank'));
    }

    /**
     * @param \App\Http\Requests\BankUpdateRequest $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function update(BankUpdateRequest $request, Bank $bank)
    {
        $this->authorize('update', $bank);

        $validated = $request->validated();

        $bank->update($validated);

        return redirect()
            ->route('banks.edit', $bank)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Bank $bank)
    {
        $this->authorize('delete', $bank);

        $bank->delete();

        return redirect()
            ->route('banks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
