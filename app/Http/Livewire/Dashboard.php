<?php

namespace App\Http\Livewire;

use App\Models\Income;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $user;
    public $account;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount() {
        $this->user = Auth::user();
        if ($this->user->isAuxiliar()) {

        }
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

        $this->showingModal = false;
    }

    public function render()
    {
        $accounts = $this->user->accounts;

        return view('livewire.dashboard', compact('accounts'));
    }
}
