<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChangeLoggedUserPassword extends Component
{

    public $isOpen = false;

    protected $listeners = ['openChangeLoggedUserPassword'];
    public function openChangeLoggedUserPassword()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }


    public function render()
    {
        return view('livewire.change-logged-user-password');
    }
}
