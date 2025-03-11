<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Equipment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\EquipmentExport;
use Maatwebsite\Excel\Facades\Excel;

class EquipmentTab extends Component
{
    use WithPagination;
    public $searchString = '';
    public $searchBy = 'brand';
    public $totalEquipments;
    public $itemPerPage = 10;

    public $orderByString = 'acquired_date';
    public $orderBySort = 'desc';

    protected $listeners = ['refreshEquipment' => 'refreshTable'];
    public $employees = [];
    public $units = [];

    public $personFilter, $locationFilter, $dateFilter;

    public function refreshTable(): void
    {
        $this->personFilter = '';
        $this->locationFilter = '';
        $this->dateFilter = '';
        $this->resetPage();
    }

    public function filterTable()
    {
        $this->resetPage();
    }

    public function searchFilter()
    {
        $this->refreshTable();
    }

    public function clearSearchString()
    {
        $this->searchString = "";
        $this->refreshTable();
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
            ->leftJoin('infosys.division', 'infosys.division.division_id', '=', 'infosys.unit.unit_div')
            ->select('infosys.unit.*', 'infosys.division.division_code') // Include necessary columns
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function downloadTable()
    {
        return Excel::download(new EquipmentExport(
            $this->personFilter,
            $this->locationFilter,
            $this->dateFilter,
            $this->searchBy ?? 'equipment.id',
            $this->searchString ?? '',
            $this->orderByString ?? 'equipment.id',
            $this->orderBySort ?? 'asc'
        ), 'equipment.xlsx');
    }

    // setters

    public function setOrderBy($field)
    {
        $this->orderByString = $field;
    }

    public function setOrderBySort()
    {
        if ($this->orderBySort == "asc") {

            $this->orderBySort = "desc";
        } elseif ($this->orderBySort == "desc") {
            $this->orderBySort = "asc";

        }
    }

    public function getEquipmentsProperty()
    {
        // return DB::connection('mysql')
        //     ->table('equipment')
        //     ->join('equipment_type', 'equipment.equipment_type_id', '=', 'equipment_type.equipment_type_id')
        //     ->join('infosys.employee', 'equipment.person_accountable_id', '=', 'infosys.employee.employee_id')
        //     ->join('infosys.unit', 'equipment.current_location_id', '=', 'infosys.unit.unit_id')
        //     ->join('infosys.division', 'infosys.division.division_id', '=', 'infosys.unit.unit_div')
        //     ->select('equipment.*', 'equipment_type.equipment_name', DB::raw("CONCAT(infosys.employee.lastname,', ', infosys.employee.firstname) as name"), 'infosys.unit.unit_desc', 'infosys.unit.unit_code', 'infosys.division.division_code')
        //     ->where($this->searchBy, 'like', "$this->searchString%")
        //     ->orderBy($this->orderByString, $this->orderBySort)
        //     ->paginate($this->itemPerPage);

        return DB::connection('mysql')
            ->table('equipment')
            ->join('equipment_type', 'equipment.equipment_type_id', '=', 'equipment_type.equipment_type_id')
            ->join('infosys.employee', 'equipment.person_accountable_id', '=', 'infosys.employee.employee_id')
            ->leftJoin('infosys.unit', 'equipment.current_location_id', '=', 'infosys.unit.unit_id')
            ->leftJoin('infosys.division', 'infosys.division.division_id', '=', 'infosys.unit.unit_div')
            ->select(
                'equipment.*',
                'equipment_type.equipment_name',
                DB::raw("CONCAT(infosys.employee.lastname, ', ', infosys.employee.firstname) as name"),
                'infosys.unit.unit_desc',
                'infosys.unit.unit_code',
                'infosys.division.division_code'
            )
            ->when($this->personFilter, function ($query) {
                return $query->where('equipment.person_accountable_id', $this->personFilter);
            })
            ->when($this->locationFilter, function ($query) {
                return $query->where('equipment.current_location_id', $this->locationFilter);
            })
            ->when($this->dateFilter, function ($query) {
                return $query->whereDate('equipment.acquired_date', $this->dateFilter);
            })
            ->where($this->searchBy, 'like', "$this->searchString%")
            ->orderBy($this->orderByString, $this->orderBySort)
            ->paginate($this->itemPerPage);

    }

    public function addItem()
    {
        $this->emit('openAddEquipment');
    }

    public function editItem($equipment_id)
    {
        $this->emit('openEditEquipment', $equipment_id);
    }
    public function transferEquipment($equipment_id)
    {
        $this->emit('openTransferEquipment', $equipment_id);
    }

    public function openEquipmentHistory($equipment_id)
    {
        $this->emit('openEquipmentHistory', $equipment_id);
    }

    // system default methods

    public function updatedOrderBySort()
    {
        $this->refreshTable();
    }

    public function updatedOrderByString()
    {
        $this->refreshTable();
    }

    public function updatedItemPerPage()
    {
        $this->refreshTable();
    }

    public function updatedSearchBy()
    {
        $this->refreshTable();
    }

    public function mount()
    {
        $this->populateEmployees();
        $this->populateUnits();
        $this->totalEquipments = Equipment::count();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('scrollToTop');

        return view('livewire.equipment-tab', ['equipments' => $this->equipments]);
    }
}