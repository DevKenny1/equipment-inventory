<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Location;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class LocationTab extends Component
{
    use WithPagination;
    public $searchString = '';
    public $searchBy = "description";
    public $totalLocations;
    public $itemPerPage = 10;

    public $orderByString = 'description';
    public $orderBySort = 'desc';

    public $add_location_open = false;

    protected $listeners = ['refreshLocations' => 'refreshTable', "closeAddLocation"];

    public function closeAddLocation()
    {
        $this->add_location_open = false;
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

    public function openEditLocation($location_id)
    {
        $this->emit('openEditLocation', $location_id);
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

    public function getLocationsProperty()
    {
        return DB::connection(name: 'mysql')
            ->table('location')
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
        $this->totalLocations = Location::count();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('scrollToTop');

        return view('livewire.location-tab', ['locations' => $this->locations]);
    }
}