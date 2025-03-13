<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferHistory extends Model
{
    use HasFactory;

    protected $table = 'equipment_transfer_history'; // Define the correct table name

    protected $primaryKey = 'equipment_transfer_history_id'; // Set primary key if not 'id'

    public $incrementing = true; // Ensure auto-incrementing is enabled

    protected $keyType = 'int'; // Specify primary key type

    protected $fillable = ['equipment_id', 'date_of_transfer', 'transfer_location_id', 'transfer_person_accountable_id', 'transfer_person_unit_id'];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


}
