<?php

namespace App\Http\Livewire;

use App\Models\Color;
use Livewire\Component;
use App\Models\Purpose;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ColorPurposesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Color $color;
    public Purpose $purpose;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Purpose';

    protected $rules = [
        'purpose.name' => ['required', 'max:255', 'string'],
        'purpose.code' => ['nullable', 'max:255'],
    ];

    public function mount(Color $color)
    {
        $this->color = $color;
        $this->resetPurposeData();
    }

    public function resetPurposeData()
    {
        $this->purpose = new Purpose();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPurpose()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.color_purposes.new_title');
        $this->resetPurposeData();

        $this->showModal();
    }

    public function editPurpose(Purpose $purpose)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.color_purposes.edit_title');
        $this->purpose = $purpose;

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

        if (!$this->purpose->color_id) {
            $this->authorize('create', Purpose::class);

            $this->purpose->color_id = $this->color->id;
        } else {
            $this->authorize('update', $this->purpose);
        }

        $this->purpose->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Purpose::class);

        Purpose::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPurposeData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->color->purposes as $purpose) {
            array_push($this->selected, $purpose->id);
        }
    }

    public function render()
    {
        return view('livewire.color-purposes-detail', [
            'purposes' => $this->color->purposes()->paginate(20),
        ]);
    }
}
