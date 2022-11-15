<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Expense;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationHeader extends Component
{
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $accounts = $this->user->accounts->modelKeys();
        $today = Carbon::now();
        $day = $today->toDateString();
        $two_days = $today->add(2, 'day');

        $events = Expense::whereIn('account_id', $accounts)
            ->where('date', '>=', $day.' 00:00:00')
            ->where('date', '<=', $two_days->format('Y-m-d').' 23:59:59')
            ->limit(5)
            ->get();
        return view('livewire.notification-header', compact('events'));
    }
}
