<?php
namespace App\Http\Controllers\Api;

use App\Models\Purpose;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseCollection;

class PurposeExpensesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Purpose $purpose)
    {
        $this->authorize('view', $purpose);

        $search = $request->get('search', '');

        $expenses = $purpose
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Purpose $purpose, Expense $expense)
    {
        $this->authorize('update', $purpose);

        $purpose->expenses()->syncWithoutDetaching([$expense->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Purpose $purpose
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Purpose $purpose,
        Expense $expense
    ) {
        $this->authorize('update', $purpose);

        $purpose->expenses()->detach($expense);

        return response()->noContent();
    }
}
