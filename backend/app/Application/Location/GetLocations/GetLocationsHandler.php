<?php

declare(strict_types=1);

namespace App\Application\Location\GetLocations;

use App\Application\Shared\PaginatedResult;
use App\Domain\Location\ILocationRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;

final class GetLocationsHandler
{
    public function __construct(
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(?string $workshopId = null, int $page = 1, int $perPage = 15): PaginatedResult
    {
        $wsId = $workshopId !== null ? new WorkshopId((int) $workshopId) : null;

        $items = array_map(
            fn ($location) => new LocationDTO(
                id: $location->id()->value,
                workshop_id: $location->workshopId()->value,
                name: $location->name()->value,
                address: $location->address(),
            ),
            $this->locations->findPaginated($page, $perPage, $wsId),
        );

        return new PaginatedResult(
            items: $items,
            total: $this->locations->countAll($wsId),
            page: $page,
            perPage: $perPage,
        );
    }
}
