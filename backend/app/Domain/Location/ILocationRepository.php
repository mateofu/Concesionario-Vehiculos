<?php

declare(strict_types=1);

namespace App\Domain\Location;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Workshop\ValueObjects\WorkshopId;

interface ILocationRepository
{
    public function save(Location $location): void;

    public function findById(LocationId $id): ?Location;

    /** @return Location[] */
    public function findAll(): array;

    /** @return Location[] */
    public function findByWorkshop(WorkshopId $workshopId): array;
}
