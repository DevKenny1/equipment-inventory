<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;

class AddLocation extends Component
{
    public $description, $status = 1;
    public $isOpen = false; // Track modal state
    protected $listeners = ['openAddLocation'];

    protected $rules = [
        'description' => 'required|max:255',
    ];

    protected $messages = [
        "description.required" => "*Description name is required.",
        "description.max" => "*Description name is too long.",
    ];

    public function addLocation()
    {
        $this->description = trim($this->description);

        $this->validate();

        $newLocation = Location::create([
            'description' => $this->description,
            'status' => $this->status
        ]);

        if ($newLocation) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'New Location',
                'message' => 'New location is successfully added in the database.',
                'type' => 'success'
            ]);
            $this->closeModal();
            $this->emit('refreshLocations');
            return;
        }
        $this->dispatchBrowserEvent('showNotification', [
            'title' => 'New Location',
            'message' => 'Created location failed.',
            'type' => 'error'
        ]);
    }

    public function openAddLocation()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
        $this->reset(); // Reset fields
    }

    public function render()
    {
        return view('livewire.add-location');
    }
}
