<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\Income;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $user;
    public $account;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount() {
        $this->user = Auth::user();
    }

    public function render()
    {
        $accounts = $this->user->accounts;
        return view('livewire.dashboard', compact('accounts'));
    }
}
