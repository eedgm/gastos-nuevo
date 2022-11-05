<?php

namespace App\Http\Livewire;

use App\Models\Income;
use App\Models\Account;
use Livewire\Component;

class NewIncome extends Component
{
    public Income $income;
    public Account $account;

    public $incomeDate;

    public $showingModal = false;
    public $modalTitle = 'New Income';

    protected $rules = [
        'incomeDate' => ['required', 'date'],
        'income.cost' => ['required', 'numeric'],
        'income.description' => ['nullable', 'max:255', 'string'],
    ];

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount(Account $account)
    {
        $this->account = $account;
    }

    public function addIncome(Account $account)
    {
        $this->account = $account;
        $this->showingModal = true;

        $this->income = new Income();

        $this->incomeDate = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function saveIncome()
    {
        $this->validate();

        if (!$this->income->account_id) {
            $this->income->account_id = $this->account->id;
        } else {
            $this->authorize('update', $this->income);
        }

        $this->income->date = \Carbon\Carbon::parse($this->incomeDate);

        $this->income->save();

        $this->emit('refreshComponent');

        $this->showingModal = false;
    }

    public function render()
    {
        return view('livewire.new-income', ['account' => $this->account]);
    }
}
