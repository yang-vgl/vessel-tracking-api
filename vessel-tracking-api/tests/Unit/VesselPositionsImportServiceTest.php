<?php

namespace Tests\Unit;

use App\Models\VesselPosition;
use App\Services\VesselPosition\JsonMachineFactory;
use App\Services\VesselPosition\VesselPositionFactory;
use App\Services\VesselPosition\VesselPositionsImportService;
use ArrayObject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Iterator;
use Mockery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VesselPositionsImportServiceTest extends TestCase
{
    private JsonMachineFactory|MockObject $jsonMachineFactoryMock;

    private Iterator|MockObject $iteratorMock;

    private VesselPositionFactory|MockObject $vesselPositionFactoryMock;

    private ArrayObject|MockObject $itemsMock;

    private VesselPosition|MockObject $vesselPositionModelMock;

    private VesselPositionsImportService $subject;

    public function setUp(): void
    {
        $this->jsonMachineFactoryMock = $this->createMock(JsonMachineFactory::class);
        $this->itemsMock = $this->getMockBuilder(ArrayObject::class)->getMock();
        $this->iteratorMock = $this->createMock(Iterator::class);
        $this->vesselPositionFactoryMock = $this->createMock(VesselPositionFactory::class);
        $this->vesselPositionModelMock = Mockery::mock(VesselPosition::class);

        $this->subject = new VesselPositionsImportService(
            $this->jsonMachineFactoryMock,
            $this->vesselPositionFactoryMock,
        );
    }

    /**
     * @dataProvider provideVesselPositionData
     */
    public function testImport(bool $isValid, object $jsonData, array $modelData): void
    {
        $this->jsonMachineFactoryMock
            ->method('createFileReader')
            ->with($this->subject::VESSEL_POSITION_FILE_URL)
            ->willReturn($this->itemsMock);

        $this->itemsMock
            ->method('getIterator')
            ->willReturn($this->iteratorMock);

        $this->iteratorMock
            ->expects(self::exactly(2))
            ->method('valid')
            ->willReturn(true, false,);

        $this->iteratorMock
            ->expects(self::once())
            ->method('current')
            ->willReturn($jsonData);

        if ($isValid === true) {
            DB::shouldReceive('raw')->andReturn("POINT({$jsonData->lon},{$jsonData->lat})");

            $this->vesselPositionFactoryMock
                ->expects(self::once())
                ->method('create')
                ->with($modelData)
                ->willReturn($this->vesselPositionModelMock);
        } else {
            Log::shouldReceive('error')->andReturnNull();
        }

        $this->subject->import();
    }

    public function provideVesselPositionData(): array
    {
        return [
            [
                true,
                (object)[
                    'mmsi' => 247039300,
                    'status' => 0,
                    'stationId' => 81,
                    'speed' => 180,
                    'lon' => 15.4415,
                    'lat' => 42.75178,
                    'course' =>144,
                    'heading' => 144,
                    'rot' => '',
                    'timestamp' => 1372683960,
                ],
                [
                    'mmsi' => 247039300,
                    'status' => 0,
                    'station_id' => 81,
                    'speed' => 180,
                    'coordinates' => 'POINT(15.4415,42.75178)',
                    'course' =>144,
                    'heading' => 144,
                    'rot' => '',
                    'timestamp' => 1372683960,
                ]
            ],
            [
                false,
                (object)[],
                []
            ],
        ];
    }
}
