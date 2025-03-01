<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EquipmentType;

class AddEquipmentType extends Component
{
    public $equipment_name, $description;
    public $isOpen = false; // Track modal state

    protected $listeners = ['openAddEquipmentType']; // Listen for events from the table component

    protected $rules = [
        'equipment_name' => 'required|max:255',
        'description' => 'required'
    ];

    protected $messages = [
        "equipment_name.required" => "*Equipment name is required.",
        "equipment_name.max" => "*Equipment name is too long.",
        "description.required" => "*Description is required.",
    ];

    public function createType()
    {
        $this->equipment_name = trim($this->equipment_name);
        $this->description = trim($this->description);

        $this->validate();

        $equipment_type = EquipmentType::create(
            [
                'equipment_name' => $this->equipment_name,
                'description' => $this->description
            ]
        );

        if ($equipment_type) {

            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'New Equipment Type',
                'message' => 'New equipment type is successfully added in the database.',
                'type' => 'success'
            ]);

            $this->closeModal();

            // Emit event to table component to refresh data
            $this->emit('refreshEquipmentTypes');

            return;
        }
    }

    public function openAddEquipmentType()
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
        return view('livewire.add-equipment-type');
    }
}
