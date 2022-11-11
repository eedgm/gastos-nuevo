<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Account;
use Livewire\Component;

class DashboardUpdateAccount extends Component
{
    public Account $account;
    public Bank $bank;

    public $modalTitle = 'Actualizar Cuenta';
    public $showingModalAccount = false;

    protected $rules = [
        'account.name' => ['required', 'max:255', 'string'],
        'account.number' => ['required', 'max:255', 'string'],
        'account.type' => ['required', 'in:Ahorro,Corriente'],
        'account.owner' => ['nullable', 'max:255', 'string'],
        'account.bank_id' => ['required', 'exists:banks,id'],
        'account.description' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Account $account)
    {
        $this->showingModalAccount = false;
        $this->account = $account;
        $this->banks = Bank::pluck('name', 'id');
        $this->account->bank_id = $account->bank->name;
    }

    public function updateAccount()
    {
        $this->showingModalAccount = true;
    }

    public function render()
    {
        return view('livewire.dashboard-update-account');
    }
}
