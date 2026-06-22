<?php

declare(strict_types=1);

namespace App\Application\Vehicle\GetVehicle;

final readonly class VehicleDTO
{
    public function __construct(
        public string $id,
        public string $owner_id,
        public string $license_plate,
        public string $brand,
        public string $model,
        public int $year,
    ) {}
}
