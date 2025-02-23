<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TransferHistory;
use Illuminate\Support\Facades\DB;

class TransferEquipment extends Component
{
    public $name, $location;
    public $transfer_person, $transfer_location;
    public $equipment_id, $date_of_transfer, $transfer_person_accountable_id, $transfer_location_id;
    public $isOpen = false; // Track modal state

    public $employees = [];
    public $units = [];

    protected $listeners = ['openTransferEquipment']; // Listen for events from the table component

    protected $rules = [
        'transfer_person' => 'required',
        'transfer_location' => 'required'
    ];

    protected $messages = [
        "transfer_person.required" => "*Please select transfer person accountable.",
        "transfer_location.required" => "*Please select transfer location.",
    ];

    public function transferEquipment()
    {
        $this->validate();

        $equipment = DB::table('equipment')
            ->where('equipment_id', $this->equipment_id)->update([
                    'person_accountable_id' => $this->transfer_person,
                    'current_location_id' => $this->transfer_location,
                ]);

        $transfer_equipment = TransferHistory::create(
            [
                'equipment_id' => $this->equipment_id,
                'date_of_transfer' => now()->format('Y-m-d'),
                'transfer_person_accountable_id' => $this->transfer_person,
                'transfer_location_id' => $this->transfer_location,
            ]
        );

        if ($equipment && $transfer_equipment) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Transfer Equipment',
                'message' => 'Equipment is successfully transferred',
                'type' => 'success'
            ]);

            // Emit event to table component to refresh data
            $this->emit('refreshEquipment');

            $this->closeModal();
        }
    }

    public function openTransferEquipment($equipment_id)
    {
        $this->equipment_id = $equipment_id;

        $equipment = DB::connection('mysql')
            ->table('equipment')
            ->join('equipment_type', 'equipment.equipment_type_id', '=', 'equipment_type.equipment_type_id')
            ->join('infosys.employee', 'equipment.person_accountable_id', '=', 'infosys.employee.employee_id')
            ->join('infosys.unit', 'equipment.current_location_id', '=', 'infosys.unit.unit_id')
            ->select('equipment.*', 'equipment_type.equipment_name', DB::raw("CONCAT(infosys.employee.lastname,', ', infosys.employee.firstname) as name"), 'infosys.unit.unit_desc', 'infosys.unit.unit_code')->where("equipment_id", "=", $equipment_id)->get()[0];

        $this->name = $equipment->name;
        $this->location = $equipment->unit_desc;

        $this->populateEmployees();
        $this->populateUnits();
        $this->isOpen = true;
    }

    public function populateEmployees()
    {
        $this->employees = DB::table('infosys.employee')
            ->orderBy('lastname', 'asc')
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

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
        $this->reset(); // Reset fields
    }

    public function render()
    {
        return view('livewire.transfer-equipment');
    }
}
