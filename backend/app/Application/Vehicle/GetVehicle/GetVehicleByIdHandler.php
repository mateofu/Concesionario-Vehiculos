<?php

declare(strict_types=1);

namespace App\Application\Vehicle\GetVehicle;

use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use RuntimeException;

final class GetVehicleByIdHandler
{
    public function __construct(
        private readonly IVehicleRepository $vehicles,
    ) {}

    public function handle(string $id): VehicleDTO
    {
        $vehicle = $this->vehicles->findById(new VehicleId($id));

        if ($vehicle === null) {
            throw new RuntimeException("Vehicle [{$id}] not found.");
        }

        return new VehicleDTO(
            id: $vehicle->id()->value,
            owner_id: $vehicle->ownerId()->value,
            license_plate: $vehicle->licensePlate()->value,
            brand: $vehicle->brand(),
            model: $vehicle->model(),
            year: $vehicle->year()->value,
        );
    }
}
