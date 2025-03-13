<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\EquipmentType;

class AddEquipmentType extends Component
{
    public $equipment_name, $description, $status = 1;

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
                'description' => $this->description,
                'status' => $this->status,
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

    public function closeModal()
    {
        $this->resetErrorBag();
        $this->emit("closeAddEquipmentType");
    }

    public function render()
    {
        return view('livewire.add-equipment-type');
    }
}
