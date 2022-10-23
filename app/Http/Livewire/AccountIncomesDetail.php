<?php

namespace App\Http\Livewire;

use App\Models\Income;
use Livewire\Component;
use App\Models\Account;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountIncomesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Account $account;
    public Income $income;
    public $incomeDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Income';

    protected $rules = [
        'incomeDate' => ['required', 'date'],
        'income.cost' => ['required', 'numeric'],
        'income.description' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Account $account)
    {
        $this->account = $account;
        $this->resetIncomeData();
    }

    public function resetIncomeData()
    {
        $this->income = new Income();

        $this->incomeDate = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newIncome()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.account_incomes.new_title');
        $this->resetIncomeData();

        $this->showModal();
    }

    public function editIncome(Income $income)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.account_incomes.edit_title');
        $this->income = $income;

        $this->incomeDate = $this->income->date->format('Y-m-d');

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

        if (!$this->income->account_id) {
            $this->authorize('create', Income::class);

            $this->income->account_id = $this->account->id;
        } else {
            $this->authorize('update', $this->income);
        }

        $this->income->date = \Carbon\Carbon::parse($this->incomeDate);

        $this->income->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Income::class);

        Income::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetIncomeData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->account->incomes as $income) {
            array_push($this->selected, $income->id);
        }
    }

    public function render()
    {
        return view('livewire.account-incomes-detail', [
            'incomes' => $this->account->incomes()->paginate(20),
        ]);
    }
}
