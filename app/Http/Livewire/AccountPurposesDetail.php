<?php

namespace App\Http\Livewire;

use App\Models\Color;
use App\Models\Account;
use App\Models\Purpose;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountPurposesDetail extends Component
{
    use AuthorizesRequests;

    public Account $account;
    public Purpose $purpose;
    public $purposesForSelect = [];
    public $purpose_id = null;
    public $purpose_name = null;
    public $color_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Purpose';
    public $newProposal = false;

    protected $rules = [
        'purpose_id' => ['nullable', 'exists:purposes,id'],
        'color_id' => ['nullable', 'exists:colors,id'],
    ];

    public function mount(Account $account)
    {
        $this->account = $account;
        $this->purposesForSelect = Purpose::pluck('name', 'id');
        $this->newProposal = false;
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
        $this->modalTitle = trans('crud.account_purposes.new_title');
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

    public function updatedPurposeId($value)
    {
        if (strlen($value) > 3) {
            if (!Purpose::where('name', 'like',  "%{$value}%")->exists()) {
                $this->newProposal = true;
            } else {
                $this->newProposal = false;
            }
        }
    }

    public function save()
    {
        $this->authorize('create', Purpose::class);

        if (!Purpose::where('name', $this->purpose_id)->exists()) {
            $purpose = Purpose::create(['name' => $this->purpose_id, 'color_id' => $this->color_id]);
            $this->purpose_id = $purpose->id;
            $this->purposesForSelect = Purpose::pluck('name', 'id');
        } else {
            $this->purpose_id = Purpose::where('name', $this->purpose_id)->first()->id;
        }

        $this->account->purposes()->sync($this->purpose_id, []);

        $this->hideModal();
    }

    public function detach($purpose)
    {
        $this->authorize('delete-any', Purpose::class);

        $this->account->purposes()->detach($purpose);

        $this->resetPurposeData();
    }

    public function render()
    {
        $colors = Color::pluck('name', 'id');

        return view('livewire.account-purposes-detail', [
            'accountPurposes' => $this->account
                ->purposes()
                ->withPivot([])
                ->paginate(20),
            'colors' => $colors
        ]);
    }
}
