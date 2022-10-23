<?php

namespace App\Http\Livewire;

use App\Models\Assign;
use Livewire\Component;
use App\Models\Expense;
use App\Models\Cluster;
use App\Models\Account;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AssignExpensesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Assign $assign;
    public Expense $expense;
    public $clustersForSelect = [];
    public $accountsForSelect = [];
    public $expenseDate;
    public $expenseDateTo;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Expense';

    protected $rules = [
        'expenseDate' => ['required', 'date'],
        'expenseDateTo' => ['nullable', 'date'],
        'expense.description' => ['nullable', 'max:255', 'string'],
        'expense.cluster_id' => ['required', 'exists:clusters,id'],
        'expense.budget' => ['required', 'numeric'],
        'expense.account_id' => ['required', 'exists:accounts,id'],
    ];

    public function mount(Assign $assign)
    {
        $this->assign = $assign;
        $this->clustersForSelect = Cluster::pluck('name', 'id');
        $this->accountsForSelect = Account::pluck('name', 'id');
        $this->resetExpenseData();
    }

    public function resetExpenseData()
    {
        $this->expense = new Expense();

        $this->expenseDate = null;
        $this->expenseDateTo = null;
        $this->expense->cluster_id = null;
        $this->expense->account_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newExpense()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.assign_expenses.new_title');
        $this->resetExpenseData();

        $this->showModal();
    }

    public function editExpense(Expense $expense)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.assign_expenses.edit_title');
        $this->expense = $expense;

        $this->expenseDate = $this->expense->date->format('Y-m-d');
        $this->expenseDateTo = $this->expense->date_to->format('Y-m-d');

        $this->dispatchBrowserEvent('refresh');

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

        if (!$this->expense->assign_id) {
            $this->authorize('create', Expense::class);

            $this->expense->assign_id = $this->assign->id;
        } else {
            $this->authorize('update', $this->expense);
        }

        $this->expense->date = \Carbon\Carbon::parse($this->expenseDate);
        $this->expense->date_to = \Carbon\Carbon::parse($this->expenseDateTo);

        $this->expense->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Expense::class);

        Expense::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetExpenseData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->assign->expenses as $expense) {
            array_push($this->selected, $expense->id);
        }
    }

    public function render()
    {
        return view('livewire.assign-expenses-detail', [
            'expenses' => $this->assign->expenses()->paginate(20),
        ]);
    }
}
