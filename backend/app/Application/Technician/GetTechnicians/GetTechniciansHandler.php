<?php

declare(strict_types=1);

namespace App\Application\Technician\GetTechnicians;

use App\Domain\Technician\ITechnicianRepository;

final class GetTechniciansHandler
{
    public function __construct(
        private readonly ITechnicianRepository $technicians,
    ) {}

    /** @return TechnicianDTO[] */
    public function handle(): array
    {
        return array_map(
            fn ($t) => new TechnicianDTO(
                id: $t->id()->value,
                name: $t->name()->value,
                email: $t->email()->value,
                phone: $t->phone()->value,
                specialty: $t->specialty()->value,
                is_available: $t->isAvailable(),
            ),
            $this->technicians->findAll(),
        );
    }
}
