<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{

    public $tab = "equipment";

    protected $queryString = [
        'tab' => ['except' => 'equipment'],
    ];
    public function render()
    {
        return view('livewire.dashboard');
    }

    public function changeTab($tabName)
    {
        $this->tab = $tabName; // Update the tab value
    }
}
