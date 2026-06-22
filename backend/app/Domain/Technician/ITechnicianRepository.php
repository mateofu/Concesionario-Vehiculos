<?php

declare(strict_types=1);

namespace App\Domain\Technician;

use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;

interface ITechnicianRepository
{
    public function save(Technician $technician): void;

    public function findById(TechnicianId $id): ?Technician;

    public function findByEmail(TechnicianEmail $email): ?Technician;

    /** @return Technician[] */
    public function findAll(): array;
}
