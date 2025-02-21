<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class AddEquipment extends Component
{
    public $equipment_type_id, $brand, $model, $serial_number, $mr_no, $employee_id, $acquired_date, $unit_id, $remarks;
    public $isOpen = false; // Track modal state

    protected $listeners = ['openAddEquipment']; // Listen for events from the table component

    public $equipment_types = [];
    public $employees = [];
    public $units = [];

    protected $rules = [
        'equipment_type_id' => 'required',
        'brand' => 'max:50',
        'model' => 'max:50',
        'serial_number' => 'max:50',
        'acquired_date' => 'required',
        'unit_id' => 'required',
        'employee_id' => 'required',
    ];

    protected $messages = [
        "equipment_type_id.required" => "*Select equipment type",
        "acquired_date.required" => "*Select acquired date",
        "unit_id.required" => "*Select current location",
        "employee_id.required" => "*Select person accountable",
        "brand.max" => "*Brand too long",
        "model.max" => "*Model too long",
        "serial_number.max" => "*Serial number too long",
    ];

    public function createEquipment()
    {
        $this->brand = trim($this->brand);
        $this->model = trim($this->model);
        $this->serial_number = trim($this->serial_number);
        $this->mr_no = trim($this->mr_no);
        $this->remarks = trim($this->remarks);

        $this->validate();

        $equipment = Equipment::create(
            [
                'equipment_type_id' => $this->equipment_type_id,
                'brand' => $this->brand,
                'model' => $this->model,
                'acquired_date' => $this->acquired_date,
                'current_location_id' => $this->unit_id,
                'serial_number' => $this->serial_number,
                'mr_no' => $this->mr_no,
                'person_accountable_id' => $this->employee_id,
                'remarks' => $this->remarks,
            ]
        );

        if ($equipment) {

            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'New Equipment',
                'message' => 'New equipment is successfully added in the database.',
                'type' => 'success'
            ]);

            $this->closeModal();

            // Emit event to table component to refresh data
            // $this->emit('refreshEquipmentTypes');

            return;
        }
    }

    public function openAddEquipment()
    {
        $this->populateEmployees();
        $this->populateUnits();
        $this->populateEquipmentTypes();
        $this->isOpen = true;

    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
        $this->reset(); // Reset fields
    }

    public function populateEmployees()
    {
        $this->employees = DB::table('infosys.employee')
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function populateUnits()
    {
        $this->units = DB::table('infosys.unit')
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
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
        return view('livewire.add-equipment');
    }
}