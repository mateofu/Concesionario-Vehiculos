<?php

declare(strict_types=1);

namespace App\Application\Location\CreateLocation;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;
use App\Domain\Workshop\IWorkshopRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use RuntimeException;

final class CreateLocationHandler
{
    public function __construct(
        private readonly ILocationRepository $locations,
        private readonly IWorkshopRepository $workshops,
    ) {}

    public function handle(CreateLocationCommand $command): int
    {
        $workshopId = new WorkshopId((int) $command->workshopId);

        if ($this->workshops->findById($workshopId) === null) {
            throw new RuntimeException("Workshop [{$command->workshopId}] not found.");
        }

        $location = Location::create(
            new LocationId(0),
            new LocationName($command->name),
            $command->address,
            $workshopId,
        );

        return $this->locations->save($location);
    }
}
