<?php

declare(strict_types=1);

namespace App\Application\Workshop\GetWorkshops;

use App\Domain\Workshop\IWorkshopRepository;

final class GetWorkshopsHandler
{
    public function __construct(
        private readonly IWorkshopRepository $workshops,
    ) {}

    /** @return WorkshopDTO[] */
    public function handle(): array
    {
        return array_map(
            fn ($w) => new WorkshopDTO(
                id: $w->id()->value,
                name: $w->name()->value,
                address: $w->address(),
                cost_center: $w->costCenter()->value,
            ),
            $this->workshops->findAll(),
        );
    }
}
