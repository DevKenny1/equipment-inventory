<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{

    public $name;

    public function openChangeLoggedUserPassword()
    {
        $this->emit('openChangeLoggedUserPassword');
    }

    public function mount()
    {
        $employee_id = Auth::user()->employee_id;
        $user = DB::table('infosys.employee')->where('infosys.employee.employee_id', $employee_id)->first();
        $this->name = $user->lastname . ', ' . $user->firstname;
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
