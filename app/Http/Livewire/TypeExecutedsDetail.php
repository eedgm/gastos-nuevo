<?php

namespace App\Http\Livewire;

use App\Models\Type;
use Livewire\Component;
use App\Models\Expense;
use App\Models\Executed;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TypeExecutedsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Type $type;
    public Executed $executed;
    public $expensesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Executed';

    protected $rules = [
        'executed.cost' => ['required', 'numeric'],
        'executed.description' => ['nullable', 'max:255', 'string'],
        'executed.expense_id' => ['required', 'exists:expenses,id'],
    ];

    public function mount(Type $type)
    {
        $this->type = $type;
        $this->expensesForSelect = Expense::pluck('date_to', 'id');
        $this->resetExecutedData();
    }

    public function resetExecutedData()
    {
        $this->executed = new Executed();

        $this->executed->expense_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newExecuted()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.type_executeds.new_title');
        $this->resetExecutedData();

        $this->showModal();
    }

    public function editExecuted(Executed $executed)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.type_executeds.edit_title');
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

        if (!$this->executed->type_id) {
            $this->authorize('create', Executed::class);

            $this->executed->type_id = $this->type->id;
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

        foreach ($this->type->executeds as $executed) {
            array_push($this->selected, $executed->id);
        }
    }

    public function render()
    {
        return view('livewire.type-executeds-detail', [
            'executeds' => $this->type->executeds()->paginate(20),
        ]);
    }
}
