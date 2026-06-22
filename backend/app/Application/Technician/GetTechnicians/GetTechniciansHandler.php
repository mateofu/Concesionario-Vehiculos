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
            fn ($technician) => new TechnicianDTO(
                $technician->id()->value,
                $technician->name()->value,
                $technician->email()->value,
                $technician->phone()->value,
            ),
            $this->technicians->findAll(),
        );
    }
}
