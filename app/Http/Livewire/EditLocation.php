<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;

class EditLocation extends Component
{
    public $description, $status;
    public $location_id;
    public $isOpen = false; // Track modal state
    protected $listeners = ['openEditLocation'];

    protected $rules = [
        'description' => 'required|max:255',
    ];

    protected $messages = [
        "description.required" => "*Description name is required.",
        "description.max" => "*Description name is too long.",
    ];

    public function openEditLocation($location_id)
    {
        if ($location_id) {
            $location = Location::find($location_id);
            $this->location_id = $location_id;
            $this->description = $location->description;
            $this->status = $location->status;
            $this->isOpen = true;
        }
    }

    public function updateLocation()
    {
        $this->description = trim($this->description);

        $this->validate();

        $updatedLocation = Location::where("location_id", $this->location_id)->update([
            'description' => $this->description,
            'status' => $this->status
        ]);

        if ($updatedLocation) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'New Location',
                'message' => 'New location is successfully added in the database.',
                'type' => 'success'
            ]);
            $this->closeModal();
            $this->emit('refreshLocations');
            return;
        }
        $this->closeModal();
        return;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.edit-location');
    }
}
