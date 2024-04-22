<?php

namespace App\Services\VesselPosition;

use App\Models\VesselPosition;

class VesselPositionFactory
{
    public function create(array $array) : VesselPosition
    {
        return VesselPosition::create($array);
    }
}
