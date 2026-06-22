<?php

declare(strict_types=1);

namespace App\Application\Technician\GetTechnicians;

use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\ValueObjects\TechnicianId;
use RuntimeException;

final class GetTechnicianByIdHandler
{
    public function __construct(
        private readonly ITechnicianRepository $technicians,
    ) {}

    public function handle(string $id): TechnicianDTO
    {
        $technician = $this->technicians->findById(new TechnicianId((int) $id));

        if ($technician === null) {
            throw new RuntimeException("Technician [{$id}] not found.");
        }

        return new TechnicianDTO(
            id: $technician->id()->value,
            name: $technician->name()->value,
            email: $technician->email()->value,
            phone: $technician->phone()->value,
            specialty: $technician->specialty()->value,
            is_available: $technician->isAvailable(),
        );
    }
}
