<?php

declare(strict_types=1);

namespace App\Application\WorkStation\CreateWorkStation;

use App\Domain\Workshop\IWorkshopRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;
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
        private readonly IWorkshopRepository $workshops,
    ) {}

    public function handle(CreateWorkStationCommand $command): int
    {
        $workshopId = new WorkshopId((int) $command->workshopId);

        if ($this->workshops->findById($workshopId) === null) {
            throw new RuntimeException("Workshop [{$command->workshopId}] not found.");
        }

        $workStation = WorkStation::create(
            new WorkStationId(0),
            new WorkStationName($command->name),
            $workshopId,
            $command->stationNumber,
            new TechnicalArea($command->technicalArea),
        );

        return $this->workStations->save($workStation);
    }
}
