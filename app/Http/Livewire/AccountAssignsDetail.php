<?php

namespace App\Http\Livewire;

use App\Models\Assign;
use Livewire\Component;
use App\Models\Account;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountAssignsDetail extends Component
{
    use AuthorizesRequests;

    public Account $account;
    public Assign $assign;
    public $assignsForSelect = [];
    public $assign_id = null;
    public $assign_name = null;

    public $showingModal = false;
    public $modalTitle = 'New Assign';

    protected $rules = [
        'assign_id' => ['nullable', 'exists:assigns,id'],
        'assign_name' => ['nullable', 'string'],
    ];

    public function mount(Account $account)
    {
        $this->account = $account;
        $this->assignsForSelect = Assign::pluck('name', 'id');
        $this->resetAssignData();
    }

    public function resetAssignData()
    {
        $this->assign = new Assign();

        $this->assign_id = null;

        $this->assign_name = '';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newAssign()
    {
        $this->modalTitle = trans('crud.account_assigns.new_title');
        $this->resetAssignData();

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

        $this->authorize('create', Assign::class);

        if ($this->assign_name) {
            $assign = Assign::create(['name' => $this->assign_name]);
            $this->assign_id = $assign->id;
        }

        $this->account->assigns()->attach($this->assign_id, []);

        $this->hideModal();
    }

    public function detach($assign)
    {
        $this->authorize('delete-any', Assign::class);

        $this->account->assigns()->detach($assign);

        $this->resetAssignData();
    }

    public function render()
    {
        return view('livewire.account-assigns-detail', [
            'accountAssigns' => $this->account
                ->assigns()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
