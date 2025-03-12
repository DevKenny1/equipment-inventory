<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\EquipmentType;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EquipmentTypeTab extends Component
{
    use WithPagination;
    public $searchString = '';
    public $searchBy = "description";
    public $totalEquipmentTypes;
    public $itemPerPage = 10;

    public $orderByString = 'equipment_name';
    public $orderBySort = 'asc';

    public $add_equipment_type_open = false;

    protected $listeners = ['refreshEquipmentTypes' => 'refreshTable', "closeAddEquipmentType"];

    public function closeAddEquipmentType()
    {
        $this->add_equipment_type_open = false;
    }
 
    public function refreshTable()
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

    public function openAddEquipmentType()
    {
        $this->emit('openAddEquipmentType');
    }
    public function openEditEquipmentType($equipment_type_id)
    {
        $this->emit('openEditEquipmentType', $equipment_type_id);
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

    public function getEquipmentTypesProperty()
    {
        return DB::connection('mysql')
            ->table('equipment_type')
            ->where($this->searchBy, 'like', $this->searchString . '%')
            ->orderBy($this->orderByString, $this->orderBySort)
            ->paginate($this->itemPerPage);
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
        $this->totalEquipmentTypes = EquipmentType::count();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('scrollToTop');

        return view('livewire.equipment-type-tab', ['equipmentTypes' => $this->equipmentTypes]);
    }
}