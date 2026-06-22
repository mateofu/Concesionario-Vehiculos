<?php

declare(strict_types=1);

namespace App\Application\Location\GetLocations;

use App\Domain\Location\ILocationRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;

final class GetLocationsHandler
{
    public function __construct(
        private readonly ILocationRepository $locations,
    ) {}

    /** @return LocationDTO[] */
    public function handle(?string $workshopId = null): array
    {
        $locations = $workshopId !== null
            ? $this->locations->findByWorkshop(new WorkshopId((int) $workshopId))
            : $this->locations->findAll();

        return array_map(
            fn ($location) => new LocationDTO(
                id: $location->id()->value,
                workshop_id: $location->workshopId()->value,
                name: $location->name()->value,
                address: $location->address(),
            ),
            $locations,
        );
    }
}
