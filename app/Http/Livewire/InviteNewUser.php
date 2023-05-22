<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Mail\sendInvitation;
use App\Models\InvitationUser;
use Illuminate\Support\Facades\Mail;

class InviteNewUser extends Component
{
    public $showingModal = false;
    public $email;
    public $permission;
    public $modalTitle = 'Enviar Invitación';

    public function mount()
    {
        $this->showingModal = false;
    }

    public function newInvitation()
    {
        $this->showingModal = true;
    }

    public function send()
    {
        $details = [
            'email' => $this->email,
            'permission' => $this->permission
        ];

        InvitationUser::create(['email' => $this->email, 'hash' => $this->permission]);

        Mail::to($this->email)->send(new sendInvitation($details));
        // $this->showingModal = false;

        session()->flash('message', 'Invitación enviada!');
    }

    public function render()
    {
        return view('livewire.invite-new-user');
    }
}
