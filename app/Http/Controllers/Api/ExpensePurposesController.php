<?php
namespace App\Http\Controllers\Api;

use App\Models\Expense;
use App\Models\Purpose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurposeCollection;

class ExpensePurposesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Expense $expense)
    {
        $this->authorize('view', $expense);

        $search = $request->get('search', '');

        $purposes = $expense
            ->purposes()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurposeCollection($purposes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Expense $expense, Purpose $purpose)
    {
        $this->authorize('update', $expense);

        $expense->purposes()->syncWithoutDetaching([$purpose->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @param \App\Models\Purpose $purpose
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Expense $expense,
        Purpose $purpose
    ) {
        $this->authorize('update', $expense);

        $expense->purposes()->detach($purpose);

        return response()->noContent();
    }
}
