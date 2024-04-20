<?php

namespace App\Services;

use App\Models\VesselPosition;

class VesselPositionFactory
{
    public function create(array $array) : bool
    {
        return VesselPosition::create($array);
    }
}
