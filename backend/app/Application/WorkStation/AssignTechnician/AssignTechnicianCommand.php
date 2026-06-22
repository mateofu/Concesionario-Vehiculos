<?php

declare(strict_types=1);

namespace App\Application\WorkStation\AssignTechnician;

final readonly class AssignTechnicianCommand
{
    public function __construct(
        public string $workStationId,
        public string $technicianId,
    ) {}
}
