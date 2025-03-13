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
    public $locations = [];

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

        // fetch person accountable details
        $person_accountable = DB::table("infosys.employee")->where("employee_id", $this->transfer_person)->first();

        $equipment = DB::table('equipment')
            ->where('equipment_id', $this->equipment_id)->update([
                    'person_accountable_id' => $this->transfer_person,
                    'person_accountable_unit_id' => $person_accountable->unit_unit_id,
                    'location_id' => $this->transfer_location,
                ]);

        if ($equipment) {
            $transfer_equipment = TransferHistory::create(
                [
                    'equipment_id' => $this->equipment_id,
                    'date_of_transfer' => now()->format('Y-m-d'),
                    'transfer_person_accountable_id' => $this->transfer_person,
                    'transfer_person_unit_id' => $person_accountable->unit_unit_id,
                    'transfer_location_id' => $this->transfer_location,
                ]
            );

            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Transfer Equipment',
                'message' => 'Equipment is successfully transferred',
                'type' => 'success'
            ]);


            // Emit event to table component to refresh data
            $this->emit('refreshEquipment');
            $this->closeModal();
        } else {
            $this->addError('transfer_person', message: '*The selected fields is the same with the current data.');
            $this->addError('transfer_location', '*The selected fields is the same with the current data.');
            return;
        }

    }

    public function openTransferEquipment($equipment_id)
    {
        $this->equipment_id = $equipment_id;

        $equipment = DB::connection('mysql')
            ->table('equipment')
            ->leftJoin('equipment_type', 'equipment.equipment_type_id', '=', 'equipment_type.equipment_type_id')
            ->leftJoin('infosys.employee', 'equipment.person_accountable_id', '=', 'infosys.employee.employee_id')
            ->leftJoin('location', 'equipment.location_id', '=', 'location.location_id')
            ->select(
                'equipment.*',
                'equipment_type.equipment_name',
                DB::raw("CONCAT(infosys.employee.lastname,', ', infosys.employee.firstname) as name"),
                DB::raw("location.description as location_description"),
            )
            ->where("equipment_id", "=", $equipment_id)
            ->get()[0];

        $this->name = $equipment->name;
        $this->location = $equipment->location_description;
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


    public function populateLocation()
    {
        $this->locations = DB::table('location')
            ->where("status", 1)
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->dispatchBrowserEvent('clear-transfer-employee');
        $this->dispatchBrowserEvent('clear-transfer-location');
        $this->resetErrorBag();
    }

    public function mount()
    {
        $this->populateEmployees();
        $this->populateLocation();
    }

    public function render()
    {
        return view('livewire.transfer-equipment');
    }
}
