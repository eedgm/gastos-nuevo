<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $user;


    public function mount() {
        $this->user = Auth::user();
        if ($this->user->isAuxiliar()) {

        }
    }

    public function render()
    {
        $accounts = $this->user->accounts;

        return view('livewire.dashboard', compact('accounts'));
    }
}
