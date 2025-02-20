<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Equipment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EquipmentTab extends Component
{
    use WithPagination;
    public $searchString = '';
    public $searchBy = '';
    public $totalEquipments;
    public $itemPerPage = 10;

    public $orderByString = '';
    public $orderBySort = 'desc';

    protected $listeners = ['refreshUsers' => 'refreshTable'];

    public function refreshTable(): void
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

    public function openEditUser($user_id)
    {

        $this->emit('openEditUser', $user_id);
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
        return DB::connection('mysql')
            ->table('equipment')
            ->join('equipment_type', 'equipment.equipment_type_id', '=', 'equipment_type.equipment_type_id')
            ->join('infosys.employee', 'equipment.person_accountable_id', '=', 'infosys.employee.employee_id')
            ->join('infosys.unit', 'equipment.current_location_id', '=', 'infosys.unit.unit_id')
            ->select('equipment.*', 'equipment_type.equipment_name', 'infosys.employee.firstname', 'infosys.employee.lastname', 'infosys.unit.unit_desc')
            ->paginate($this->itemPerPage);
    }

    public function createNewUser()
    {
        return redirect()->route('create-user');
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
        $this->totalEquipments = Equipment::count();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('scrollToTop');

        return view('livewire.equipment-tab', ['equipments' => $this->equipments]);
    }
}