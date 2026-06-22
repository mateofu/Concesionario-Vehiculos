<?php

declare(strict_types=1);

namespace App\Domain\Location;

use App\Domain\Location\ValueObjects\LocationId;

interface ILocationRepository
{
    public function save(Location $location): int;

    public function findById(LocationId $id): ?Location;

    /** @return Location[] */
    public function findAll(): array;

    public function findPaginated(int $page, int $perPage): array;

    public function countAll(): int;
}
