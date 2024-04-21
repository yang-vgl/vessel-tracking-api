<?php

namespace App\Services;

use App\Models\VesselPosition;

class VesselPositionFactory
{
    public function create(array $array) : VesselPosition
    {
        return VesselPosition::create($array);
    }
}
