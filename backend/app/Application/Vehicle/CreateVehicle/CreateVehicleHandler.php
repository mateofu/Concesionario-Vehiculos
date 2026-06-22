<?php

declare(strict_types=1);

namespace App\Application\Vehicle\CreateVehicle;

use App\Domain\Owner\IOwnerRepository;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\Vehicle\ValueObjects\LicensePlate;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\Vehicle\ValueObjects\VehicleYear;
use App\Domain\Vehicle\Vehicle;
use Illuminate\Support\Str;
use RuntimeException;

final class CreateVehicleHandler
{
    public function __construct(
        private readonly IVehicleRepository $vehicles,
        private readonly IOwnerRepository $owners,
    ) {}

    public function handle(CreateVehicleCommand $command): string
    {
        $ownerId = new OwnerId($command->ownerId);

        if ($this->owners->findById($ownerId) === null) {
            throw new RuntimeException("Owner [{$command->ownerId}] not found.");
        }

        $plate = new LicensePlate($command->licensePlate);

        if ($this->vehicles->findByLicensePlate($plate) !== null) {
            throw new RuntimeException("A vehicle with license plate [{$plate->value}] already exists.");
        }

        $id = new VehicleId((string) Str::uuid());

        $vehicle = Vehicle::create(
            $id,
            $ownerId,
            $plate,
            $command->brand,
            $command->model,
            new VehicleYear($command->year),
        );

        $this->vehicles->save($vehicle);

        return $id->value;
    }
}
