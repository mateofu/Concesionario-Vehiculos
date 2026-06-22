<?php

declare(strict_types=1);

namespace App\Domain\Vehicle;

use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\ValueObjects\LicensePlate;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\Vehicle\ValueObjects\VehicleYear;

final class Vehicle
{
    private function __construct(
        private readonly VehicleId $id,
        private readonly OwnerId $ownerId,
        private LicensePlate $licensePlate,
        private string $brand,
        private string $model,
        private VehicleYear $year,
    ) {}

    public static function create(
        VehicleId $id,
        OwnerId $ownerId,
        LicensePlate $licensePlate,
        string $brand,
        string $model,
        VehicleYear $year,
    ): self {
        return new self($id, $ownerId, $licensePlate, $brand, $model, $year);
    }

    public function id(): VehicleId
    {
        return $this->id;
    }

    public function ownerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function licensePlate(): LicensePlate
    {
        return $this->licensePlate;
    }

    public function brand(): string
    {
        return $this->brand;
    }

    public function model(): string
    {
        return $this->model;
    }

    public function year(): VehicleYear
    {
        return $this->year;
    }
}
