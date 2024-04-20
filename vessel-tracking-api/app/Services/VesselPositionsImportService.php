<?php

namespace App\Services;

use App\Models\VesselPosition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JsonMachine\Exception\InvalidArgumentException;

class VesselPositionsImportService
{
    public const VESSEL_POSITION_FILE_URL = 'https://kpler.github.io/kp-recruitment/a2d6f4f07f5aca0f0a49c076f6a36cede56ce76e/ship_positions.json';

    public function __construct(
        private readonly JsonMachineFactory $jsonMachineFactory,
        private readonly VesselPositionFactory $vesselPositionFactory,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function import(): void
    {
        $vesselPositions = $this->jsonMachineFactory->createFileReader(self::VESSEL_POSITION_FILE_URL);

        foreach ($vesselPositions as $vesselPosition) {
            try {
                $this->vesselPositionFactory->create([
                    'mmsi' => $vesselPosition->mmsi,
                    'status' => $vesselPosition->status,
                    'station_id' => $vesselPosition->stationId,
                    'speed' => $vesselPosition->speed,
                    'coordinates' =>  DB::raw(sprintf('POINT(%f, %f)', $vesselPosition->lon, $vesselPosition->lat)),
                    'course' => $vesselPosition->course,
                    'heading' => $vesselPosition->heading,
                    'rot' => $vesselPosition->rot,
                    'timestamp' => $vesselPosition->timestamp,
                ]);
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
    }


}
