<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class EditEquipment extends Component
{
    public $equipment_id, $equipment_type_id, $brand, $model, $serial_number, $mr_no, $name, $acquired_date, $unit_name, $remarks;
    public $isOpen = false; // Track modal state

    protected $listeners = ['openEditEquipment']; // Listen for events from the table component

    public $equipment_types = [];

    protected $rules = [
        'equipment_type_id' => 'required',
        'brand' => 'max:50',
        'model' => 'max:50',
        'serial_number' => 'max:50',
        'acquired_date' => 'required',
    ];

    protected $messages = [
        "equipment_type_id.required" => "*Select equipment type",
        "acquired_date.required" => "*Select acquired date",
        "brand.max" => "*Brand too long",
        "model.max" => "*Model too long",
        "serial_number.max" => "*Serial number too long",
    ];

    public function editEquipment()
    {
        $this->brand = trim($this->brand);
        $this->model = trim($this->model);
        $this->serial_number = trim($this->serial_number);
        $this->mr_no = trim($this->mr_no);
        $this->remarks = trim($this->remarks);

        $this->validate();

        $equipment = DB::table('equipment')
            ->where('equipment_id', $this->equipment_id)->update([
                    'equipment_type_id' => $this->equipment_type_id,
                    'brand' => $this->brand,
                    'model' => $this->model,
                    'serial_number' => $this->serial_number,
                    'mr_no' => $this->mr_no,
                    'acquired_date' => $this->acquired_date,
                    'remarks' => $this->remarks,
                ]);

        if ($equipment) {

            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Edit Equipment',
                'message' => 'Equipment successfully updated',
                'type' => 'success'
            ]);

            $this->closeModal();

            // Emit event to table component to refresh data
            $this->emit('refreshEquipment');

            return;
        }
    }

    public function deleteEquipment()
    {
        $equipment = Equipment::destroy($this->equipment_id);

        if ($equipment) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Delete Equipment',
                'message' => 'Equipment successfully deleted',
                'type' => 'success'
            ]);

            $this->closeModal();

            // Emit event to table component to refresh data
            $this->emit('refreshEquipment');

            return;
        }
    }

    public function openEditEquipment($equipment_id)
    {
        $this->populateEquipmentTypes();

        $equipment = DB::connection('mysql')
            ->table('equipment')
            ->join('equipment_type', 'equipment.equipment_type_id', '=', 'equipment_type.equipment_type_id')
            ->join('infosys.employee', 'equipment.person_accountable_id', '=', 'infosys.employee.employee_id')
            ->join('infosys.unit', 'equipment.current_location_id', '=', 'infosys.unit.unit_id')
            ->select('equipment.*', 'equipment_type.equipment_name', DB::raw("CONCAT(infosys.employee.lastname,', ', infosys.employee.firstname) as name"), 'infosys.unit.unit_desc', 'infosys.unit.unit_code')
            ->where('equipment_id', $equipment_id)->first();

        $this->equipment_id = $equipment_id;
        $this->equipment_type_id = $equipment->equipment_type_id;
        $this->brand = $equipment->brand;
        $this->model = $equipment->model;
        $this->serial_number = $equipment->serial_number;
        $this->mr_no = $equipment->mr_no;
        $this->name = $equipment->name;
        $this->acquired_date = $equipment->acquired_date;
        $this->unit_name = $equipment->unit_desc;
        $this->remarks = $equipment->remarks;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
    }

    public function populateEquipmentTypes()
    {
        $this->equipment_types = DB::table('equipment_type')
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function render()
    {
        return view('livewire.edit-equipment');
    }
}