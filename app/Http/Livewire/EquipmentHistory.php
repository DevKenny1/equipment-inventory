<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TransferHistory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class EquipmentHistory extends Component
{
    use WithPagination;


    public $totalEquipmentHistories = 0;

    public $equipment_id = 0;

    public $itemPerPage = 10;

    public $orderBySort = 'asc';

    public $isOpen = false; // Track modal state

    protected $listeners = ['openEquipmentHistory']; // Listen for events from the table component

    public function openEquipmentHistory($equipment_id)
    {
        $this->equipment_id = $equipment_id;
        $this->isOpen = true;
    }

    public function getEquipmentHistoriesProperty()
    {
        return DB::connection('mysql')
            ->table('equipment_transfer_history')
            ->join('infosys.employee', 'equipment_transfer_history.transfer_person_accountable_id', '=', 'infosys.employee.employee_id')
            ->join('infosys.unit', 'equipment_transfer_history.transfer_location_id', '=', 'infosys.unit.unit_id')
            ->select('equipment_transfer_history.*', DB::raw("CONCAT(infosys.employee.lastname,', ', infosys.employee.firstname) as name"), 'infosys.unit.unit_desc', 'infosys.unit.unit_code')->where('equipment_id', 'like', $this->equipment_id)
            ->orderBy('equipment_transfer_history_id', $this->orderBySort)
            ->paginate($this->itemPerPage);
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function mount()
    {
        $this->totalEquipmentHistories = TransferHistory::count();
    }

    public function render()
    {
        return view('livewire.equipment-history', ['equipmentHistories' => $this->equipmentHistories]);
    }
}
