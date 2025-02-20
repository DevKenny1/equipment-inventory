<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EquipmentType;

class EditEquipmentType extends Component
{
    public $equipment_type_id, $equipment_name, $description;
    public $isOpen = false; // Track modal state

    protected $listeners = ['openEditEquipmentType']; // Listen for events from the table component

    protected $rules = [
        'equipment_name' => 'required|max:255',
        'description' => 'required'
    ];

    protected $messages = [
        "equipment_name.required" => "*Equipment name is required.",
        "equipment_name.max" => "*Equipment name is too long.",
        "description.required" => "*Description is required.",
    ];

    public function updateType()
    {

        $this->equipment_name = trim($this->equipment_name);
        $this->description = trim($this->description);

        $this->validate();

        $equipment_type = EquipmentType::where("equipment_type_id", $this->equipment_type_id)->update(
            [
                'equipment_name' => $this->equipment_name,
                'description' => $this->description
            ]
        );

        if ($equipment_type) {

            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Update Equipment Type',
                'message' => 'Equipment type is successfully updated.',
                'type' => 'success'
            ]);

            $this->closeModal();

            // Emit event to table component to refresh data
            $this->emit('refreshEquipmentTypes');

            return;
        }
    }

    public function openEditEquipmentType($equipment_type_id)
    {
        if ($equipment_type_id) {
            $equipment_type = EquipmentType::find($equipment_type_id);
            $this->equipment_name = $equipment_type->equipment_name;
            $this->description = $equipment_type->description;
            $this->equipment_type_id = $equipment_type_id;
            $this->isOpen = true;
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
        $this->reset(); // Reset fields
    }

    public function render()
    {
        return view('livewire.edit-equipment-type');
    }
}
