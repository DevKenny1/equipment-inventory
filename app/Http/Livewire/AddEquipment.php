<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\TransferHistory;
use Illuminate\Support\Facades\DB;

class AddEquipment extends Component
{
    public $equipment_type_id, $brand, $model, $acquired_date, $location_id, $serial_number, $mr_no, $person_accountable_id, $remarks;

    public $equipment_types = [];
    public $employees = [];
    public $units = [];

    public $locations = [];

    protected $rules = [
        'equipment_type_id' => 'required',
        'brand' => 'max:50',
        'model' => 'max:50',
        'serial_number' => 'max:50',
        'acquired_date' => 'required',
        'location_id' => 'required',
        'person_accountable_id' => 'required',
    ];

    protected $messages = [
        "equipment_type_id.required" => "*Select equipment type",
        "acquired_date.required" => "*Select acquired date",
        "location_id.required" => "*Select location",
        "person_accountable_id.required" => "*Select person accountable",
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

        // fetch person accountable details
        $person_accountable = DB::table("infosys.employee")->where("employee_id", $this->person_accountable_id)->first();

        $equipment = Equipment::create(
            [
                'equipment_type_id' => $this->equipment_type_id,
                'brand' => $this->brand,
                'model' => $this->model,
                'acquired_date' => $this->acquired_date,
                'location_id' => $this->location_id,
                'serial_number' => $this->serial_number,
                'mr_no' => $this->mr_no,
                'person_accountable_id' => $this->person_accountable_id,
                'person_accountable_unit_id' => $person_accountable->unit_unit_id,
                'remarks' => $this->remarks,
            ]
        );

        $transfer_equipment = TransferHistory::create(
            [
                'equipment_id' => $equipment->equipment_id,
                'date_of_transfer' => now()->format('Y-m-d'),
                'transfer_person_accountable_id' => $equipment->person_accountable_id,
                'transfer_person_unit_id' => $person_accountable->unit_unit_id,
                'transfer_location_id' => $equipment->location_id,
            ]
        );

        if ($equipment && $transfer_equipment) {

            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'New Equipment',
                'message' => 'New equipment is successfully added in the database.',
                'type' => 'success'
            ]);

            $this->closeModal();

            // Emit event to table component to refresh data
            $this->emit('refreshEquipment');

            return;
        }
    }


    public function closeModal()
    {
        $this->resetErrorBag();
        $this->equipment_type_id = null;
        $this->location_id = null;
        $this->person_accountable_id = null;
        $this->emit("closeAddEquipment");
        $this->dispatchBrowserEvent('clear-employee');
        $this->dispatchBrowserEvent('clear-location');
        $this->dispatchBrowserEvent('clear-equipment-type');
    }

    public function populateEmployees()
    {
        $this->employees = DB::table('infosys.employee')
            ->orderBy('lastname', 'asc')
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function populateLocation()
    {
        $this->locations = DB::table('location')
            ->where("status", 1)
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function populateEquipmentTypes()
    {
        $this->equipment_types = DB::table('equipment_type')
            ->where("status", 1)
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function mount()
    {
        $this->populateEmployees();
        $this->populateLocation();
        $this->populateEquipmentTypes();
    }

    public function render()
    {
        return view('livewire.add-equipment');
    }
}