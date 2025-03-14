<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class EquipmentExport implements FromQuery, WithHeadings
{
    protected $personFilter;
    protected $locationFilter;
    protected $dateFilter;
    protected $searchBy;
    protected $searchString;
    protected $orderByString;
    protected $orderBySort;

    public function __construct($personFilter = null, $locationFilter = null, $dateFilter = null, $searchBy = 'equipment.id', $searchString = '', $orderByString = 'equipment.id', $orderBySort = 'asc')
    {
        $this->personFilter = $personFilter;
        $this->locationFilter = $locationFilter;
        $this->dateFilter = $dateFilter;
        $this->searchBy = $searchBy;
        $this->searchString = $searchString;
        $this->orderByString = $orderByString;
        $this->orderBySort = $orderBySort;
    }

    public function query()
    {
        return DB::connection('mysql')
            ->table('equipment')
            ->join('equipment_type', 'equipment.equipment_type_id', '=', 'equipment_type.equipment_type_id')
            ->join('infosys.employee', 'equipment.person_accountable_id', '=', 'infosys.employee.employee_id')
            ->leftJoin('infosys.unit', 'equipment.person_accountable_unit_id', '=', 'infosys.unit.unit_id')
            ->leftJoin('infosys.division', 'infosys.division.division_id', '=', 'infosys.unit.unit_div')
            ->leftJoin('location', 'equipment.location_id', '=', 'location.location_id')
            ->select(
                'equipment_type.equipment_name',
                'equipment.brand',
                'equipment.model',
                'equipment.serial_number',
                'equipment.mr_no',
                DB::raw("CONCAT(infosys.employee.lastname, ', ', infosys.employee.firstname) as name"),
                DB::raw("CONCAT(infosys.unit.unit_code,'/',infosys.division.division_code) as section_division"),
                DB::raw("location.description as location_description"),
                'equipment.acquired_date',
                'equipment.remarks'
            )
            ->when($this->personFilter, function ($query) {
                return $query->where('equipment.person_accountable_id', $this->personFilter);
            })
            ->when($this->locationFilter, function ($query) {
                return $query->where('equipment.current_location_id', $this->locationFilter);
            })
            ->when($this->dateFilter, function ($query) {
                return $query->whereDate('equipment.acquired_date', $this->dateFilter);
            })->when($this->searchBy === 'section_division' || $this->searchBy === 'location_description', function ($query) {
                return $query->having($this->searchBy, 'like', "$this->searchString%");
            }, function ($query) {
                return $query->where($this->searchBy, 'like', "$this->searchString%");
            })
            ->orderBy($this->orderByString, $this->orderBySort);
    }

    public function headings(): array
    {
        return [
            'Equipment Type',
            'Brand',
            'Model',
            'Serial number',
            'MR NO',
            'Person accountable',
            'Section/Division',
            'Location',
            'Acquired date',
            'Remarks'
        ];
    }
}
