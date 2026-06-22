<?php

declare(strict_types=1);

namespace App\Domain\Workshop;

use App\Domain\Workshop\ValueObjects\WorkshopId;

interface IWorkshopRepository
{
    public function save(Workshop $workshop): int;

    public function findById(WorkshopId $id): ?Workshop;

    /** @return Workshop[] */
    public function findAll(): array;

    public function findPaginated(int $page, int $perPage): array;

    public function countAll(): int;
}
