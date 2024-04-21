<?php

namespace Database\Seeders;

use App\Models\VesselPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VesselPositionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {
        $testData = [
            [
                "mmsi" => 247039301,
                "status" => 0,
                "stationId" => 81,
                "speed" => 180,
                "lon" => 15.4415,
                "lat" => 42.75178,
                "course" => 144,
                "heading" => 144,
                "rot" => "",
                "timestamp" => 1372683960
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 82,
                "speed" => 154,
                "lon" => 16.21578,
                "lat" => 42.03212,
                "course" => 149,
                "heading" => 150,
                "rot" => "",
                "timestamp" => 1372700340
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 83,
                "speed" => 157,
                "lon" => 14.36933,
                "lat" => 43.81345,
                "course" => 141,
                "heading" => 142,
                "rot" => "",
                "timestamp" => 1372697580
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 84,
                "speed" => 156,
                "lon" => 16.80937,
                "lat" => 41.34813,
                "course" => 123,
                "heading" => 124,
                "rot" => "",
                "timestamp" => 1372700520
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 85,
                "speed" => 154,
                "lon" => 16.19508,
                "lat" => 42.05627,
                "course" => 143,
                "heading" => 143,
                "rot" => "",
                "timestamp" => 1372700280
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 86,
                "speed" => 151,
                "lon" => 15.89673,
                "lat" => 42.3478,
                "course" => 142,
                "heading" => 143,
                "rot" => "",
                "timestamp" => 1372700520
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 88,
                "speed" => 155,
                "lon" => 16.57032,
                "lat" => 41.57028,
                "course" => 150,
                "heading" => 150,
                "rot" => "",
                "timestamp" => 1372696500
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 89,
                "speed" => 157,
                "lon" => 16.25182,
                "lat" => 41.98653,
                "course" => 149,
                "heading" => 150,
                "rot" => "",
                "timestamp" => 1372700340
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 90,
                "speed" => 155,
                "lon" => 16.5214,
                "lat" => 41.63402,
                "course" => 149,
                "heading" => 150,
                "rot" => "",
                "timestamp" => 1372666500
            ],
            [
                "mmsi" => 247039300,
                "status" => 0,
                "stationId" => 91,
                "speed" => 155,
                "lon" => 16.11517,
                "lat" => 42.13335,
                "course" => 141,
                "heading" => 143,
                "rot" => "",
                "timestamp" => 1372691340
            ]
        ];

        $dbName = DB::connection()->getName();

        if ($dbName !== 'mysql_testing') {
            throw new \Exception('Not testing db');
        }

        foreach ($testData as $item) {
            $item['coordinates'] = DB::raw(sprintf('POINT(%f, %f)', $item['lon'],$item['lat']));
            $item['station_id'] = $item['stationId'];
            unset($item['stationId'], $item['lon'], $item['lat']);

            VesselPosition::create($item);
        }
    }
}
