<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use Livewire\Component;
use App\Models\Account;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BankAccountsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Bank $bank;
    public Account $account;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Account';

    protected $rules = [
        'account.name' => ['required', 'max:255', 'string'],
        'account.description' => ['nullable', 'max:255', 'string'],
        'account.number' => ['required', 'max:255', 'string'],
        'account.type' => ['required', 'in:Ahorro,Corriente'],
        'account.owner' => ['nullable', 'max:255', 'string'],
    ];

    public function mount(Bank $bank)
    {
        $this->bank = $bank;
        $this->resetAccountData();
    }

    public function resetAccountData()
    {
        $this->account = new Account();

        $this->account->type = 'Ahorro';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newAccount()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.bank_accounts.new_title');
        $this->resetAccountData();

        $this->showModal();
    }

    public function editAccount(Account $account)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.bank_accounts.edit_title');
        $this->account = $account;

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

        if (!$this->account->bank_id) {
            $this->authorize('create', Account::class);

            $this->account->bank_id = $this->bank->id;
        } else {
            $this->authorize('update', $this->account);
        }

        $this->account->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Account::class);

        Account::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetAccountData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->bank->accounts as $account) {
            array_push($this->selected, $account->id);
        }
    }

    public function render()
    {
        return view('livewire.bank-accounts-detail', [
            'accounts' => $this->bank->accounts()->paginate(20),
        ]);
    }
}
