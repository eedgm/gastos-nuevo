<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Purpose;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpensePurposesDetail extends Component
{
    use AuthorizesRequests;

    public Expense $expense;
    public Purpose $purpose;
    public $purposesForSelect = [];
    public $purpose_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Purpose';

    protected $rules = [
        'purpose_id' => ['required', 'exists:purposes,id'],
    ];

    public function mount(Expense $expense)
    {
        $this->expense = $expense;
        $this->purposesForSelect = Purpose::pluck('name', 'id');
        $this->resetPurposeData();
    }

    public function resetPurposeData()
    {
        $this->purpose = new Purpose();

        $this->purpose_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPurpose()
    {
        $this->modalTitle = trans('crud.expense_purposes.new_title');
        $this->resetPurposeData();

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

        $this->authorize('create', Purpose::class);

        $this->expense->purposes()->attach($this->purpose_id, []);

        $this->hideModal();
    }

    public function detach($purpose)
    {
        $this->authorize('delete-any', Purpose::class);

        $this->expense->purposes()->detach($purpose);

        $this->resetPurposeData();
    }

    public function render()
    {
        return view('livewire.expense-purposes-detail', [
            'expensePurposes' => $this->expense
                ->purposes()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
