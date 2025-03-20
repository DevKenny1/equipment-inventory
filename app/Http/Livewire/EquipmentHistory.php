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

    public $orderBySort = 'desc';

    public $isOpen = false; // Track modal state

    protected $listeners = ['update-remarks' => 'updateRemarks', 'refresh-history' => '$refresh']; // Listen for events from the table component


    public function getEquipmentHistoriesProperty()
    {
        return DB::connection('mysql')
            ->table('equipment_transfer_history')
            ->leftJoin('infosys.employee', 'equipment_transfer_history.transfer_person_accountable_id', '=', 'infosys.employee.employee_id')
            ->leftJoin('infosys.unit', 'equipment_transfer_history.transfer_person_unit_id', '=', 'infosys.unit.unit_id')
            ->leftJoin('infosys.division', 'infosys.division.division_id', '=', 'infosys.unit.unit_div')
            ->leftJoin('location', 'equipment_transfer_history.transfer_location_id', '=', 'location.location_id')
            ->select(
                'equipment_transfer_history.*',
                DB::raw("CONCAT(infosys.employee.lastname,', ', infosys.employee.firstname) as name"),
                DB::raw("location.description as location_description"),
                DB::raw("CONCAT(infosys.unit.unit_code,'/',infosys.division.division_code) as section_division"),
            )
            ->where('equipment_id', 'like', $this->equipment_id)
            ->orderBy('date_of_transfer', $this->orderBySort)
            ->paginate($this->itemPerPage);
    }

    public function closeModal()
    {
        $this->equipmentHistories = null;
        $this->isOpen = false;
    }

    public function mount($equipmentId)
    {
        $this->equipment_id = $equipmentId;
        $this->totalEquipmentHistories = TransferHistory::where('equipment_id', $equipmentId)->count();
    }

    public function render()
    {
        return view('livewire.equipment-history', ['equipmentHistories' => $this->equipmentHistories]);
    }


    public function updateRemarks($id, $new_remarks)
    {
        $updatedRemarks = TransferHistory::where('equipment_transfer_history_id', $id)->update(['remarks' => $new_remarks]);

        if ($updatedRemarks) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Transfer remarks updated.',
                'message' => 'Transfer remarks was successfully updated.',
                'type' => 'success'
            ]);
        }
    }

    public function updateTransferDate($id, $new_date_of_transfer)
    {

        if ($new_date_of_transfer === "") {
            $new_date_of_transfer = null;
        }

        $updatedRemarks = TransferHistory::where('equipment_transfer_history_id', $id)->update(['date_of_transfer' => $new_date_of_transfer]);

        if ($updatedRemarks) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'Transfer date updated.',
                'message' => 'Transfer date was successfully updated.',
                'type' => 'success'
            ]);
            return redirect()->route("dashboard");
        }
    }

    public function refreshHistory()
    {

    }
}
