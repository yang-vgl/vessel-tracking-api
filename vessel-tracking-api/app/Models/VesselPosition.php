<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;

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

    protected $casts = [
        'coordinates' => Point::class,
    ];
}
