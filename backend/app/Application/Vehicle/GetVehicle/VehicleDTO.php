<?php

declare(strict_types=1);

namespace App\Application\Vehicle\GetVehicle;

final readonly class VehicleDTO
{
    public function __construct(
        public int $id,
        public int $owner_id,
        public string $license_plate,
        public string $brand,
        public string $model,
        public int $year,
        public string $style,
    ) {}
}
