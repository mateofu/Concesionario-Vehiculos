<?php

declare(strict_types=1);

namespace App\Application\Technician\GetTechnicians;

use App\Application\Shared\PaginatedResult;
use App\Domain\Technician\ITechnicianRepository;

final class GetTechniciansHandler
{
    public function __construct(
        private readonly ITechnicianRepository $technicians,
    ) {}

    public function handle(int $page = 1, int $perPage = 15): PaginatedResult
    {
        $items = array_map(
            fn ($t) => new TechnicianDTO(
                id: $t->id()->value,
                name: $t->name()->value,
                email: $t->email()->value,
                phone: $t->phone()->value,
                specialty: $t->specialty()->value,
                is_available: $t->isAvailable(),
            ),
            $this->technicians->findPaginated($page, $perPage),
        );

        return new PaginatedResult(
            items: $items,
            total: $this->technicians->countAll(),
            page: $page,
            perPage: $perPage,
        );
    }
}
