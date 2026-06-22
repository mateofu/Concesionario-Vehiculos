<?php

declare(strict_types=1);

namespace App\Application\Technician\CreateTechnician;

final readonly class CreateTechnicianCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $specialty,
    ) {}
}
