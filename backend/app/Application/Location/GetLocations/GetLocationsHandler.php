<?php

declare(strict_types=1);

namespace App\Application\Location\GetLocations;

use App\Application\Shared\PaginatedResult;
use App\Domain\Location\ILocationRepository;

final class GetLocationsHandler
{
    public function __construct(
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(int $page = 1, int $perPage = 15): PaginatedResult
    {
        $items = array_map(
            fn ($location) => new LocationDTO(
                id: $location->id()->value,
                name: $location->name()->value,
                address: $location->address(),
            ),
            $this->locations->findPaginated($page, $perPage),
        );

        return new PaginatedResult(
            items: $items,
            total: $this->locations->countAll(),
            page: $page,
            perPage: $perPage,
        );
    }
}
