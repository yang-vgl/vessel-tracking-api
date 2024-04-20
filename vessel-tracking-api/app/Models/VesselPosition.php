<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselPosition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'mmsi',
        'status',
        'station_id',
        'speed',
        'coordinates',
        'course',
        'heading',
        'rot',
        'timestamp',
    ];
}
