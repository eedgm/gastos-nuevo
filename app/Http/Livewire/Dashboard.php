<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Income;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Expense;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $user;
    public $account;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'refreshDashboard' => '$refresh'
    ];

    public function mount() {
        $this->user = Auth::user();
        $this->dispatchBrowserEvent('refresh');
    }

    public function render()
    {
        $accounts = $this->user->accounts()->orderBy('id', 'asc')->get();
        return view('livewire.dashboard', compact('accounts',));
    }
}
