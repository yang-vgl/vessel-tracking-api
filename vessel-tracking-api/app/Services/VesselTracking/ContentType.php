<?php

namespace App\Services\VesselTracking;

enum ContentType: string
{
    case XML = 'application/xml';
    case CSV = 'text/csv';
    case JSON = 'application/json';
    case API_JSON = 'application/vnd.api+json';
}
