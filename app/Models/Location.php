<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Location extends Model
{
    use HasFactory;

    protected $table = 'location'; // Define the correct table name

    protected $primaryKey = 'location_id'; // Set primary key if not 'id'

    public $incrementing = true; // Ensure auto-incrementing is enabled

    protected $keyType = 'int'; // Specify primary key type

    protected $fillable = ['status', 'description'];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
