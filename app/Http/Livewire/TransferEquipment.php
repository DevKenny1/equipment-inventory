<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TransferHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransferEquipment extends Component
{
    public $name, $location;
    public $transfer_person, $transfer_location;
    public $equipment_id, $date_of_transfer, $transfer_person_accountable_id, $transfer_location_id, $remarks;
    public $isOpen = false; // Track modal state

    public $employees = [];
    public $locations = [];

    protected $listeners = ['openTransferEquipment']; // Listen for events from the table component

    protected $rules = [
        'transfer_person' => 'required',
        'transfer_location' => 'required',
        'date_of_transfer' => 'required'
    ];

    protected $messages = [
        "transfer_person.required" => "*Please select transfer person accountable.",
        "transfer_location.required" => "*Please select transfer location.",
        "date_of_transfer.required" => "*Please select transfer date.",
    ];

    public function transferEquipment()
    {

        $this->remarks = trim($this->remarks);

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
                    'date_of_transfer' => Carbon::now()->format('Y-m-d'),
                    'transfer_person_accountable_id' => $this->transfer_person,
                    'transfer_person_unit_id' => $person_accountable->unit_unit_id,
                    'transfer_location_id' => $this->transfer_location,
                    'remarks' => $this->remarks,
                ]
            );

            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Transfer Equipment',
                'message' => 'Equipment is successfully transferred',
                'type' => 'success'
            ]);


            // Emit event to table component to refresh data
            $this->emit('refreshEquipment');
            $this->emit('refresh-history');
            $this->transfer_person = "";
            $this->transfer_location = "";
            $this->date_of_transfer = "";
            $this->dispatchBrowserEvent('clear-transfer-employee');
            $this->dispatchBrowserEvent('clear-transfer-location');
            $this->populateFields();
            $this->closeModal();
            return redirect()->route('dashboard');
        } else {
            $this->addError('transfer_person', message: '*The selected fields is the same with the current data.');
            $this->addError('transfer_location', '*The selected fields is the same with the current data.');
            return;
        }

    }

    public function populateFields(): void
    {
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
            ->where("equipment_id", "=", $this->equipment_id)
            ->get()[0];

        $this->name = $equipment->name;
        $this->location = $equipment->location_description;
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
        // $this->remarks = "";
        // $this->name = $this->transfer_person;
        // $this->location = $this->transfer_location;
        // $this->transfer_person = "";
        // $this->transfer_location = "";
        $this->resetErrorBag();
    }

    public function mount($equipmentId)
    {
        $this->equipment_id = $equipmentId;
        $this->date_of_transfer = date('Y-m-d');
        $this->populateFields();
        $this->populateEmployees();
        $this->populateLocation();

    }

    public function render()
    {
        $this->populateFields();
        $this->populateEmployees();
        $this->populateLocation();
        return view('livewire.transfer-equipment');
    }
}
