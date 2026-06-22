<?php

declare(strict_types=1);

namespace App\Application\WorkStation\AssignTechnician;

use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use RuntimeException;

final class AssignTechnicianHandler
{
    public function __construct(
        private readonly IWorkStationRepository $workStations,
        private readonly ITechnicianRepository $technicians,
    ) {}

    public function handle(AssignTechnicianCommand $command): void
    {
        $workStationId = new WorkStationId($command->workStationId);
        $technicianId  = new TechnicianId($command->technicianId);

        if ($this->workStations->findById($workStationId) === null) {
            throw new RuntimeException("WorkStation [{$command->workStationId}] not found.");
        }

        if ($this->technicians->findById($technicianId) === null) {
            throw new RuntimeException("Technician [{$command->technicianId}] not found.");
        }

        $this->workStations->assignTechnician($workStationId, $technicianId);
    }
}
