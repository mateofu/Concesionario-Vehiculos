<?php

declare(strict_types=1);

namespace App\Application\Vehicle\CreateVehicle;

final readonly class CreateVehicleCommand
{
    public function __construct(
        public string $ownerId,
        public string $licensePlate,
        public string $brand,
        public string $model,
        public int $year,
    ) {}
}
