<?php

namespace App\Http\Livewire;

use App\Models\Assign;
use App\Models\Account;
use App\Models\Cluster;
use App\Models\Expense;
use App\Models\Purpose;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddNewEvent extends Component
{
    use AuthorizesRequests;

    public $user;
    public $clusters;
    public $assigns;
    public Expense $expense;
    public $purposes;

    public $showingModal = false;
    public $modalTitle = 'Nuevo Evento';
    public $expenseDate;
    public $expenseDateTo;
    public $purpose_id;

    protected $rules = [
        'expenseDate' => ['required', 'date'],
        'expenseDateTo' => ['nullable', 'date'],
        'expense.description' => ['nullable', 'string'],
        'expense.cluster_id' => ['required', 'exists:clusters,id'],
        'expense.assign_id' => ['required', 'exists:assigns,id'],
        'expense.account_id' => ['required', 'exists:accounts,id'],
        'purpose_id' => ['required', 'exists:purposes,id'],
        'expense.budget' => ['required', 'numeric'],
    ];

    protected $listeners = [
        'refreshDashboard' => '$refresh',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->showingModal = false;
    }

    public function updateAccountDetails(Account $account)
    {
        $this->clusters = $account->clusters()->pluck('name', 'id');
        $this->assigns = $account->assigns()->pluck('name', 'id');
        $this->purposes = $account->purposes()->pluck('name', 'id');

        $this->dispatchBrowserEvent('refresh');
    }

    public function newEvent()
    {
        $this->expense = new Expense();
        $this->showingModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->expense->account_id) {
            $this->authorize('create', Expense::class);

            $this->expense->google_id = null;

            $this->expense->date = \Carbon\Carbon::parse($this->expenseDate);
            $this->expense->date_to = \Carbon\Carbon::parse($this->expenseDateTo);
        }

        $this->expense->save();

        $this->expense->purposes()->attach($this->purpose_id, []);

        $this->emit('refreshDashboard');

        $this->showingModal = false;
    }

    public function render()
    {
        $now = \Carbon\Carbon::parse(now())->format('Y-m-d H:i');
        $accounts = $this->user->accounts()->pluck('name', 'id');
        return view('livewire.add-new-event', compact('accounts', 'now'));
    }
}
