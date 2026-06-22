<?php

declare(strict_types=1);

namespace App\Application\Workshop\GetWorkshops;

use App\Application\Shared\PaginatedResult;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Workshop\IWorkshopRepository;

final class GetWorkshopsHandler
{
    public function __construct(
        private readonly IWorkshopRepository $workshops,
    ) {}

    public function handle(?string $locationId = null, int $page = 1, int $perPage = 15): PaginatedResult
    {
        $locId = $locationId !== null ? new LocationId((int) $locationId) : null;

        $items = array_map(
            fn ($w) => new WorkshopDTO(
                id: $w->id()->value,
                location_id: $w->locationId()->value,
                name: $w->name()->value,
                address: $w->address(),
                cost_center: $w->costCenter()->value,
            ),
            $this->workshops->findPaginated($page, $perPage, $locId),
        );

        return new PaginatedResult(
            items: $items,
            total: $this->workshops->countAll($locId),
            page: $page,
            perPage: $perPage,
        );
    }
}
