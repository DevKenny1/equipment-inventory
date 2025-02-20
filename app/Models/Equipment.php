<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment'; // Define the correct table name

    protected $primaryKey = 'equipment_id'; // Set primary key if not 'id'

    public $incrementing = true; // Ensure auto-incrementing is enabled

    protected $keyType = 'int'; // Specify primary key type

    protected $fillable = ['equipment_type_id', 'brand', 'model', 'acquired_date', 'section_id', 'serial_number', 'mr_no', 'person_accountable_id', 'remarks'];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
