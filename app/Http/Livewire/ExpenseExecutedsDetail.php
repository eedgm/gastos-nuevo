<?php

namespace App\Http\Livewire;

use App\Models\Type;
use Livewire\Component;
use App\Models\Expense;
use App\Models\Executed;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpenseExecutedsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Expense $expense;
    public Executed $executed;
    public $typesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Executed';

    protected $rules = [
        'executed.cost' => ['required', 'numeric'],
        'executed.description' => ['nullable', 'max:255', 'string'],
        'executed.type_id' => ['required', 'exists:types,id'],
    ];

    public function mount(Expense $expense)
    {
        $this->expense = $expense;
        $this->typesForSelect = Type::pluck('name', 'id');
        $this->resetExecutedData();
    }

    public function resetExecutedData()
    {
        $this->executed = new Executed();

        $this->executed->type_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newExecuted()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.expense_executeds.new_title');
        $this->resetExecutedData();

        $this->showModal();
    }

    public function editExecuted(Executed $executed)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.expense_executeds.edit_title');
        $this->executed = $executed;

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

        if (!$this->executed->expense_id) {
            $this->authorize('create', Executed::class);

            $this->executed->expense_id = $this->expense->id;
        } else {
            $this->authorize('update', $this->executed);
        }

        $this->executed->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Executed::class);

        Executed::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetExecutedData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->expense->executeds as $executed) {
            array_push($this->selected, $executed->id);
        }
    }

    public function render()
    {
        return view('livewire.expense-executeds-detail', [
            'executeds' => $this->expense->executeds()->paginate(20),
        ]);
    }
}
