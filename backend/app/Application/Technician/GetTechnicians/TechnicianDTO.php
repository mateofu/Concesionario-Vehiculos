<?php

declare(strict_types=1);

namespace App\Application\Technician\GetTechnicians;

final readonly class TechnicianDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $phone,
        public string $specialty,
        public bool $is_available,
    ) {}
}
