<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Balance;
use Livewire\Component;

class NewBalance extends Component
{
    public Account $account;
    public Balance $balance;

    public $balanceDate;

    public $showingModal = false;
    public $modalTitle = 'Nuevo Balance';
    public $editing = false;
    public $balance_boton = 'Nuevo Balance';
    public $balance_icon = 'bx-plus';

    protected $rules = [
        'balanceDate' => ['required', 'date'],
        'balance.total' => ['nullable', 'numeric'],
        'balance.description' => ['nullable', 'string'],
    ];

    public function mount(Account $account)
    {
        $this->account = $account;
        $this->editing = false;
    }

    public function addBalance(Account $account)
    {
        $this->account = $account;
        $this->showingModal = true;

        $balance = Balance::where('account_id', $this->account->id)->where('reported', false)->first();

        if (!$balance) {
            $this->balance = new Balance();

            $this->balance->account_id = $this->account->id;

            $this->balanceDate = $this->balance->date = \Carbon\Carbon::now();

            $this->balanceDate = $this->balance->date->format('Y-m-d');

            $this->balance->save();
        }

        $this->dispatchBrowserEvent('refresh');
    }

    public function save()
    {
        $this->validate();

        if (!$this->balance->account_id) {
            $this->balance->account_id = $this->account->id;
        } else {
            $this->authorize('update', $this->balance);
        }

        $this->balance->date = \Carbon\Carbon::parse($this->balanceDate);

        $this->balance->save();

        $this->emit('refreshComponent');

        $this->editing = true;
    }

    public function render()
    {
        $balance = Balance::where('account_id', $this->account->id)->where('reported', false)->first();

        if ($balance) {
            $this->balance = $balance;

            $this->balanceDate = $this->balance->date->format('Y-m-d');

            $this->balance_boton = 'Balance';

            $this->balance_icon = 'bx-edit';
        }

        return view('livewire.new-balance', );
    }
}
