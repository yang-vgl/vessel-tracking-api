<?php

namespace App\Http\Controllers;

use App\Http\Requests\VesselTrackingRequestValidator;
use App\Models\VesselPosition;
use App\Services\VesselTracking\VesselTrackingResponseMapper;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use \Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

class VesselTrackingController extends Controller
{
    public function __construct(
        private readonly VesselTrackingResponseMapper $vesselTrackingResponseMapper,
    ) {
    }

    public function index(VesselTrackingRequestValidator $request): Response
    {
        $query = VesselPosition::query();

        if ($request->has('mmsi')) {
            $query->whereIn('mmsi', $request->input('mmsi'));
        }

        if ($request->has(['min_lat', 'max_lat', 'min_lon', 'max_lon'])) {
            $minLat = $request->input('min_lat');
            $maxLat = $request->input('max_lat');
            $minLon = $request->input('min_lon');
            $maxLon = $request->input('max_lon');

            $wktBoundingBox = "POLYGON(($minLon $minLat, $maxLon $minLat, $maxLon $maxLat, $minLon $maxLat, $minLon $minLat))";
            $query->whereRaw("ST_Contains(ST_GeomFromText('$wktBoundingBox'), coordinates)");
        }

        if ($request->has(['start_time', 'end_time'])) {
            $query->whereBetween('timestamp', [$request->input('start_time'), $request->input('end_time')]);
        }

        $vesselPositionData = $query->get();

        $contentType = $request->header('Accept');

        try {
            return $this->vesselTrackingResponseMapper->map($contentType, $vesselPositionData);
        } catch (Throwable $e) {
            Log::error($e);

            return new Response($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
