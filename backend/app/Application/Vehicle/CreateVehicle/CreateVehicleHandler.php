<?php

declare(strict_types=1);

namespace App\Application\Vehicle\CreateVehicle;

use App\Domain\Owner\IOwnerRepository;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\Vehicle\ValueObjects\LicensePlate;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\Vehicle\ValueObjects\VehicleStyle;
use App\Domain\Vehicle\ValueObjects\VehicleYear;
use App\Domain\Vehicle\Vehicle;
use RuntimeException;

final class CreateVehicleHandler
{
    public function __construct(
        private readonly IVehicleRepository $vehicles,
        private readonly IOwnerRepository $owners,
    ) {}

    public function handle(CreateVehicleCommand $command): int
    {
        $ownerId = new OwnerId((int) $command->ownerId);

        if ($this->owners->findById($ownerId) === null) {
            throw new RuntimeException("Owner [{$command->ownerId}] not found.");
        }

        $plate = new LicensePlate($command->licensePlate);

        if ($this->vehicles->findByLicensePlate($plate) !== null) {
            throw new RuntimeException("A vehicle with license plate [{$plate->value}] already exists.");
        }

        $vehicle = Vehicle::create(
            new VehicleId(0),
            $ownerId,
            $plate,
            $command->brand,
            $command->model,
            new VehicleYear($command->year),
            new VehicleStyle($command->style),
        );

        return $this->vehicles->save($vehicle);
    }
}
