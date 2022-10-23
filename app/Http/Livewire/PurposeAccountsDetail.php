<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Purpose;
use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PurposeAccountsDetail extends Component
{
    use AuthorizesRequests;

    public Purpose $purpose;
    public Account $account;
    public $accountsForSelect = [];
    public $account_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Account';

    protected $rules = [
        'account_id' => ['required', 'exists:accounts,id'],
    ];

    public function mount(Purpose $purpose)
    {
        $this->purpose = $purpose;
        $this->accountsForSelect = Account::pluck('name', 'id');
        $this->resetAccountData();
    }

    public function resetAccountData()
    {
        $this->account = new Account();

        $this->account_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newAccount()
    {
        $this->modalTitle = trans('crud.purpose_accounts.new_title');
        $this->resetAccountData();

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

        $this->authorize('create', Account::class);

        $this->purpose->accounts()->attach($this->account_id, []);

        $this->hideModal();
    }

    public function detach($account)
    {
        $this->authorize('delete-any', Account::class);

        $this->purpose->accounts()->detach($account);

        $this->resetAccountData();
    }

    public function render()
    {
        return view('livewire.purpose-accounts-detail', [
            'purposeAccounts' => $this->purpose
                ->accounts()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
