<?php

declare(strict_types=1);

namespace App\Domain\Vehicle;

use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\ValueObjects\LicensePlate;
use App\Domain\Vehicle\ValueObjects\VehicleId;

interface IVehicleRepository
{
    public function save(Vehicle $vehicle): void;

    public function findById(VehicleId $id): ?Vehicle;

    public function findByLicensePlate(LicensePlate $plate): ?Vehicle;

    /** @return Vehicle[] */
    public function findByOwner(OwnerId $ownerId): array;

    /** @return Vehicle[] */
    public function findAll(): array;
}
