<?php

declare(strict_types=1);

namespace App\Domain\Workshop;

use App\Domain\Workshop\ValueObjects\WorkshopId;

interface IWorkshopRepository
{
    public function save(Workshop $workshop): void;

    public function findById(WorkshopId $id): ?Workshop;

    /** @return Workshop[] */
    public function findAll(): array;
}
