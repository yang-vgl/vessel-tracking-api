<?php

namespace App\Console\Commands;

use App\Services\VesselPositionsImportService;
use Illuminate\Console\Command;
use JsonMachine\Exception\InvalidArgumentException;

class ImportVesselPositionsCommand extends Command
{
    protected $signature = 'app:import-vessel-positions';

    protected $description = 'import vessel positions';

    public function __construct(
        private readonly VesselPositionsImportService $vesselPositionsImportService,
    ) {
        parent::__construct();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        $this->vesselPositionsImportService->import();
    }
}
