<?php

declare(strict_types=1);

namespace App\Application\Workshop\GetWorkshops;

use App\Application\Shared\PaginatedResult;
use App\Domain\Workshop\IWorkshopRepository;

final class GetWorkshopsHandler
{
    public function __construct(
        private readonly IWorkshopRepository $workshops,
    ) {}

    public function handle(int $page = 1, int $perPage = 15): PaginatedResult
    {
        $items = array_map(
            fn ($w) => new WorkshopDTO(
                id: $w->id()->value,
                name: $w->name()->value,
                address: $w->address(),
                cost_center: $w->costCenter()->value,
            ),
            $this->workshops->findPaginated($page, $perPage),
        );

        return new PaginatedResult(
            items: $items,
            total: $this->workshops->countAll(),
            page: $page,
            perPage: $perPage,
        );
    }
}
