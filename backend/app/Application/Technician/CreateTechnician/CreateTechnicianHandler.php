<?php

declare(strict_types=1);

namespace App\Application\Technician\CreateTechnician;

use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\Technician;
use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Technician\ValueObjects\TechnicianName;
use App\Domain\Technician\ValueObjects\TechnicianPhone;
use App\Domain\Technician\ValueObjects\TechnicianSpecialty;
use RuntimeException;

final class CreateTechnicianHandler
{
    public function __construct(
        private readonly ITechnicianRepository $technicians,
    ) {}

    public function handle(CreateTechnicianCommand $command): int
    {
        $email = new TechnicianEmail($command->email);

        if ($this->technicians->findByEmail($email) !== null) {
            throw new RuntimeException("A technician with email [{$command->email}] already exists.");
        }

        $technician = Technician::create(
            new TechnicianId(0),
            new TechnicianName($command->name),
            $email,
            new TechnicianPhone($command->phone),
            new TechnicianSpecialty($command->specialty),
        );

        return $this->technicians->save($technician);
    }
}
