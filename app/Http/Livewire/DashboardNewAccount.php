<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardNewAccount extends Component
{
    use AuthorizesRequests;

    public $user;
    public Account $account;

    public $modalTitle = 'Nueva Cuenta';
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
        'refreshComponent' => '$refresh'
    ];

    public function mount() {

    }

    public function addAccount()
    {
        $this->showingModalAccount = true;
        $this->account = new Account();
    }

    public function saveAccount()
    {
        if (!$this->account->id) {
            $this->authorize('create', Account::class);
            if (!Bank::where('name', $this->account->bank_id)->exists()) {
                $bank = Bank::create(['name' => $this->account->bank_id]);
            }
            $this->account->bank_id = $bank->id;
        } else {
            $this->authorize('update', $this->account);
        }

        $this->account->save();

        $this->account->users()->attach($this->user->id, []);

        $this->emit('refreshComponent');

        $this->showingModalAccount = false;
    }

    public function render()
    {
        $banks = Bank::pluck('name', 'id');
        return view('livewire.dashboard-new-account', compact('banks'));
    }
}
