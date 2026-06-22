<?php

declare(strict_types=1);

namespace App\Application\WorkStation\CreateWorkStation;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\TechnicalArea;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;
use App\Domain\WorkStation\WorkStation;
use RuntimeException;

final class CreateWorkStationHandler
{
    public function __construct(
        private readonly IWorkStationRepository $workStations,
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(CreateWorkStationCommand $command): int
    {
        $locationId = new LocationId((int) $command->locationId);

        if ($this->locations->findById($locationId) === null) {
            throw new RuntimeException("Location [{$command->locationId}] not found.");
        }

        $workStation = WorkStation::create(
            new WorkStationId(0),
            new WorkStationName($command->name),
            $locationId,
            $command->stationNumber,
            new TechnicalArea($command->technicalArea),
        );

        return $this->workStations->save($workStation);
    }
}
