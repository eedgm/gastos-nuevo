<?php

namespace App\Http\Controllers\Api;

use App\Models\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\IncomeCollection;
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
            ->paginate();

        return new IncomeCollection($incomes);
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

        return new IncomeResource($income);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Income $income)
    {
        $this->authorize('view', $income);

        return new IncomeResource($income);
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

        return new IncomeResource($income);
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

        return response()->noContent();
    }
}
