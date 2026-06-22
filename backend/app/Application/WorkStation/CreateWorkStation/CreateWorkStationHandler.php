<?php

declare(strict_types=1);

namespace App\Application\WorkStation\CreateWorkStation;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;
use App\Domain\WorkStation\WorkStation;
use Illuminate\Support\Str;
use RuntimeException;

final class CreateWorkStationHandler
{
    public function __construct(
        private readonly IWorkStationRepository $workStations,
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(CreateWorkStationCommand $command): string
    {
        $locationId = new LocationId($command->locationId);

        if ($this->locations->findById($locationId) === null) {
            throw new RuntimeException("Location [{$command->locationId}] not found.");
        }

        $id = new WorkStationId((string) Str::uuid());

        $workStation = WorkStation::create(
            $id,
            new WorkStationName($command->name),
            $locationId,
        );

        $this->workStations->save($workStation);

        return $id->value;
    }
}
