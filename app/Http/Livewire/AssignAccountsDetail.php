<?php

namespace App\Http\Livewire;

use App\Models\Assign;
use Livewire\Component;
use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AssignAccountsDetail extends Component
{
    use AuthorizesRequests;

    public Assign $assign;
    public Account $account;
    public $accountsForSelect = [];
    public $account_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Account';

    protected $rules = [
        'account_id' => ['required', 'exists:accounts,id'],
    ];

    public function mount(Assign $assign)
    {
        $this->assign = $assign;
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
        $this->modalTitle = trans('crud.assign_accounts.new_title');
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

        $this->assign->accounts()->attach($this->account_id, []);

        $this->hideModal();
    }

    public function detach($account)
    {
        $this->authorize('delete-any', Account::class);

        $this->assign->accounts()->detach($account);

        $this->resetAccountData();
    }

    public function render()
    {
        return view('livewire.assign-accounts-detail', [
            'assignAccounts' => $this->assign
                ->accounts()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
