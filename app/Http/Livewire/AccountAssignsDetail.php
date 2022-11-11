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
        $this->authorize('create', Assign::class);

        if (!Assign::where('name', $this->assign_id)->exists()) {
            $assign = Assign::create(['name' => $this->assign_id]);
            $this->assign_id = $assign->id;
            $this->assignsForSelect = Assign::pluck('name', 'id');
        } else {
            $this->assign_id = Assign::where('name', $this->assign_id)->first()->id;
        }

        $this->account->assigns()->sync($this->assign_id, []);

        $this->dispatchBrowserEvent('refresh');

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
