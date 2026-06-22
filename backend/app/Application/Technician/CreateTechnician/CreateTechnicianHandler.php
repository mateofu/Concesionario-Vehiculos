<?php

declare(strict_types=1);

namespace App\Application\Technician\CreateTechnician;

use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\Technician;
use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Technician\ValueObjects\TechnicianName;
use App\Domain\Technician\ValueObjects\TechnicianPhone;
use Illuminate\Support\Str;
use RuntimeException;

final class CreateTechnicianHandler
{
    public function __construct(
        private readonly ITechnicianRepository $technicians,
    ) {}

    public function handle(CreateTechnicianCommand $command): string
    {
        $email = new TechnicianEmail($command->email);

        if ($this->technicians->findByEmail($email) !== null) {
            throw new RuntimeException("A technician with email [{$command->email}] already exists.");
        }

        $id = new TechnicianId((string) Str::uuid());

        $technician = Technician::create(
            $id,
            new TechnicianName($command->name),
            $email,
            new TechnicianPhone($command->phone),
        );

        $this->technicians->save($technician);

        return $id->value;
    }
}
