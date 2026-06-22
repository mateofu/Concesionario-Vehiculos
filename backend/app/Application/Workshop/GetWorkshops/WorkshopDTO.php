<?php

declare(strict_types=1);

namespace App\Application\Workshop\GetWorkshops;

final readonly class WorkshopDTO
{
    public function __construct(
        public int $id,
        public int $location_id,
        public string $name,
        public string $address,
        public string $cost_center,
    ) {}
}
