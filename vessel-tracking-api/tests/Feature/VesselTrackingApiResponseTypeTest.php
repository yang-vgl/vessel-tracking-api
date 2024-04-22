<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\TestCase;

class VesselTrackingApiResponseTypeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed --class=VesselPositionDataSeeder');
    }

    public function testIndexReturnsDataInJsonFormat()
    {
        $response = $this->get('/api/vessel-tracking', ['Accept' => 'application/json']);

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testIndexReturnsDataInXmlFormat()
    {
        $response = $this->get('/api/vessel-tracking', ['Accept' => 'application/xml']);

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function testIndexReturnsDataInCsvFormat()
    {
        $response = $this->get('/api/vessel-tracking', ['Accept' => 'text/csv']);

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function testIndexReturnsDataInApiJsonFormat()
    {
        $response = $this->get('/api/vessel-tracking', ['Accept' => 'application/vnd.api+json']);

        $response->assertStatus(HttpResponse::HTTP_OK);
        $response->assertHeader('Content-Type', 'application/json');
    }
}
