<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\TestCase;

class VesselTrackingApiFilterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class=VesselPositionDataSeeder');
    }

    public function testFilterByMmsi()
    {
        $response = $this->get('/api/vessel-tracking?mmsi[]=247039301', [
            'Accept' => 'application/json',
        ]);

        $response->assertJsonCount(1);

        self::assertEquals('247039301', $response->json()[0]['mmsi']);

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testFilterByCoordinate()
    {
        $maxLat = 42.75178;
        $minLat = 42.03212;
        $maxLon = 16.21578;
        $minLon = 15.4415;

        $response = $this->get("/api/vessel-tracking?max_lat=$maxLat&min_lat=$minLat&max_lon=$maxLon&min_lon=$minLon", [
            'Accept' => 'application/json',
        ]);

        $response->assertJsonCount(3);

        foreach ($response->json() as $item) {
            self::assertTrue($item['lat'] >= $minLat && $item['lat'] <= $maxLat && $item['log'] <= $maxLon && $item['log'] >= $minLon);
        }

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testFilterByTime()
    {
        $startTime = 1372683960;
        $endTime = 1372700160;

        $response = $this->get("/api/vessel-tracking?start_time={$startTime}&end_time={$endTime}", [
            'Accept' => 'application/json',
        ]);

        $response->assertJsonCount(4);

        foreach ($response->json() as $item) {
            self::assertTrue($item['timestamp'] >= $startTime && $item['timestamp'] <= $endTime);
        }

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertHeader('Content-Type', 'application/json');
    }
}
