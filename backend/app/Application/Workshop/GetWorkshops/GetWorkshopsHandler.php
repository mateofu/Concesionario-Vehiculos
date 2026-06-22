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
            fn ($workshop) => new WorkshopDTO(
                $workshop->id()->value,
                $workshop->name()->value,
                $workshop->address(),
            ),
            $this->workshops->findAll(),
        );
    }
}
