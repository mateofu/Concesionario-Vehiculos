<?php

declare(strict_types=1);

namespace App\Application\Location\GetLocations;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\ValueObjects\LocationId;
use RuntimeException;

final class GetLocationByIdHandler
{
    public function __construct(
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(string $id): LocationDTO
    {
        $location = $this->locations->findById(new LocationId((int) $id));

        if ($location === null) {
            throw new RuntimeException("Location [{$id}] not found.");
        }

        return new LocationDTO(
            id: $location->id()->value,
            workshop_id: $location->workshopId()->value,
            name: $location->name()->value,
            address: $location->address(),
        );
    }
}
