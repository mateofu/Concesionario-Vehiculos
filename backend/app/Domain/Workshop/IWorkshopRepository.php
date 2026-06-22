<?php

declare(strict_types=1);

namespace App\Domain\Workshop;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Workshop\ValueObjects\WorkshopId;

interface IWorkshopRepository
{
    public function save(Workshop $workshop): int;

    public function findById(WorkshopId $id): ?Workshop;

    /** @return Workshop[] */
    public function findAll(): array;

    /** @return Workshop[] */
    public function findByLocation(LocationId $locationId): array;

    public function findPaginated(int $page, int $perPage, ?LocationId $locationId = null): array;

    public function countAll(?LocationId $locationId = null): int;
}
