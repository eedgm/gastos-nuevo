<?php

namespace App\Http\Livewire;

use App\Models\Income;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Expense;
use Livewire\Component;

class BalanceCalculator extends Component
{
    public $modalTitle = "Agregar Detalles";
    public $account;
    public $balance;
    public $showingModal = false;

    public $allSelectedIncomes = false;
    public $selectedIncome = [];
    public $allSelectedExpenses = false;
    public $selectedExpense = [];

    public $incomes_total = 0;
    public $expenses_total = 0;
    public $exptotal = 0;

    public function mount(Account $account, Balance $balance)
    {
        $this->showingModal = false;
        $this->account = $account;
        $this->balance = $balance;
    }

    public function newBalance()
    {
        $this->showingModal = true;
    }

    public function toggleFullSelectionIncomes()
    {
        if (!$this->allSelectedIncomes) {
            $this->selectedIncome = [];
            return;
        }

        foreach ($this->incomes as $income) {
            array_push($this->selectedIncome, $income->id);
        }
    }

    public function toggleFullSelectionExpenses()
    {
        if (!$this->allSelectedExpenses) {
            $this->selectedExpense = [];
            return;
        }

        foreach ($this->expenses as $expense) {
            array_push($this->selectedExpense, $expense->id);
        }
    }

    public function save()
    {
        foreach ($this->selectedIncome as $income) {
            Income::where('id', $income)->update(['balance_id' => $this->balance->id]);
        }

        foreach ($this->selectedExpense as $expense) {
            Expense::where('id', $expense)->update(['balance_id' => $this->balance->id]);
        }

        $this->showingModal = false;
    }

    public function render()
    {
        $incomes = Income::where('balance_id', null)->where('account_id', $this->account->id)->get();
        $expenses = Expense::where('balance_id', null)->where('account_id', $this->account->id)->get();

        $incomes_result = Income::where('balance_id', $this->balance->id)->get();
        $expenses_result = Expense::where('balance_id', $this->balance->id)->get();

        return view('livewire.balance-calculator', compact('incomes', 'expenses', 'incomes_result', 'expenses_result'));
    }

    public function removeIncome($id)
    {
        Income::where('id', $id)->update(['balance_id' => null]);
    }

    public function removeExpense($id)
    {
        Expense::where('id', $id)->update(['balance_id' => null]);
    }
}
