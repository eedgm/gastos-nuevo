<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Account;
use Livewire\Component;

class GeneralUpdateAccount extends Component
{
    public Account $account;
    public Bank $bank;

    public $modalTitle = 'Actualizara Cuenta';
    public $showingModalAccount = false;

    protected $rules = [
        'account.name' => ['required', 'max:255', 'string'],
        'account.number' => ['required', 'max:255', 'string'],
        'account.type' => ['required', 'in:Ahorro,Corriente'],
        'account.owner' => ['nullable', 'max:255', 'string'],
        'account.bank_id' => ['required', 'exists:banks,id'],
        'account.description' => ['nullable', 'max:255', 'string'],
    ];

    protected $listeners = [
        'updateAccount' => 'updateAccountEmitted',
    ];

    public function updateAccountEmitted(Account $account)
    {
        $this->account = $account;
        $this->banks = Bank::pluck('name', 'id');
        $this->account->bank_id = $this->account->bank->name;
        $this->showingModalAccount = true;
    }

    public function mount()
    {
        $this->showingModalAccount = false;
        $this->banks = Bank::pluck('name', 'id');
    }

    public function updateAccount()
    {
        $this->showingModalAccount = true;
    }

    public function render()
    {
        return view('livewire.general-update-account');
    }
}
