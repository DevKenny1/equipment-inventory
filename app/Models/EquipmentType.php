<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $table = 'equipment_type'; // Define the correct table name

    protected $primaryKey = 'equipment_type_id'; // Set primary key if not 'id'

    public $incrementing = true; // Ensure auto-incrementing is enabled

    protected $keyType = 'int'; // Specify primary key type

    protected $fillable = ['equipment_name', 'description'];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
