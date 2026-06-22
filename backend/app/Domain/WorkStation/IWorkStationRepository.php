<?php

declare(strict_types=1);

namespace App\Domain\WorkStation;

use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\WorkStation\ValueObjects\WorkStationId;

interface IWorkStationRepository
{
    public function save(WorkStation $workStation): int;

    public function findById(WorkStationId $id): ?WorkStation;

    /** @return WorkStation[] */
    public function findByWorkshop(WorkshopId $workshopId): array;

    /** @return WorkStation[] */
    public function findAll(): array;

    public function assignTechnician(WorkStationId $workStationId, TechnicianId $technicianId): void;

    public function findPaginated(int $page, int $perPage): array;

    public function countAll(): int;
}
