<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\ValueObjects\LicensePlate;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\Vehicle\ValueObjects\VehicleStyle;
use App\Domain\Vehicle\ValueObjects\VehicleYear;
use App\Domain\Vehicle\Vehicle;
use App\Infrastructure\Persistence\Eloquent\Models\VehicleModel;

final class VehicleMapper
{
    public static function toDomain(VehicleModel $model): Vehicle
    {
        return Vehicle::create(
            new VehicleId((int) $model->id),
            new OwnerId((int) $model->owner_id),
            new LicensePlate($model->license_plate),
            $model->brand,
            $model->model,
            new VehicleYear($model->year),
            new VehicleStyle($model->style),
        );
    }

    public static function toModel(Vehicle $vehicle): array
    {
        return [
            'owner_id'      => $vehicle->ownerId()->value,
            'license_plate' => $vehicle->licensePlate()->value,
            'brand'         => $vehicle->brand(),
            'model'         => $vehicle->model(),
            'year'          => $vehicle->year()->value,
            'style'         => $vehicle->style()->value,
        ];
    }
}
