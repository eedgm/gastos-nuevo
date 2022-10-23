<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Purpose;
use App\Models\Expense;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PurposeExpensesDetail extends Component
{
    use AuthorizesRequests;

    public Purpose $purpose;
    public Expense $expense;
    public $expensesForSelect = [];
    public $expense_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Expense';

    protected $rules = [
        'expense_id' => ['required', 'exists:expenses,id'],
    ];

    public function mount(Purpose $purpose)
    {
        $this->purpose = $purpose;
        $this->expensesForSelect = Expense::pluck('date_to', 'id');
        $this->resetExpenseData();
    }

    public function resetExpenseData()
    {
        $this->expense = new Expense();

        $this->expense_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newExpense()
    {
        $this->modalTitle = trans('crud.purpose_expenses.new_title');
        $this->resetExpenseData();

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', Expense::class);

        $this->purpose->expenses()->attach($this->expense_id, []);

        $this->hideModal();
    }

    public function detach($expense)
    {
        $this->authorize('delete-any', Expense::class);

        $this->purpose->expenses()->detach($expense);

        $this->resetExpenseData();
    }

    public function render()
    {
        return view('livewire.purpose-expenses-detail', [
            'purposeExpenses' => $this->purpose
                ->expenses()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
