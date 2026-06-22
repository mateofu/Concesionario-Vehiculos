<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\Vehicle\ValueObjects\LicensePlate;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\Vehicle\Vehicle;
use App\Infrastructure\Persistence\Eloquent\Mappers\VehicleMapper;
use App\Infrastructure\Persistence\Eloquent\Models\VehicleModel;

final class EloquentVehicleRepository implements IVehicleRepository
{
    public function save(Vehicle $vehicle): int
    {
        $model = VehicleModel::create(VehicleMapper::toModel($vehicle));

        return $model->id;
    }

    public function findById(VehicleId $id): ?Vehicle
    {
        $model = VehicleModel::find($id->value);

        return $model ? VehicleMapper::toDomain($model) : null;
    }

    public function findByLicensePlate(LicensePlate $plate): ?Vehicle
    {
        $model = VehicleModel::where('license_plate', $plate->value)->first();

        return $model ? VehicleMapper::toDomain($model) : null;
    }

    public function findByOwner(OwnerId $ownerId): array
    {
        return VehicleModel::where('owner_id', $ownerId->value)
            ->get()
            ->map(fn ($m) => VehicleMapper::toDomain($m))
            ->all();
    }

    public function findAll(): array
    {
        return VehicleModel::all()
            ->map(fn ($m) => VehicleMapper::toDomain($m))
            ->all();
    }

    public function findPaginated(int $page, int $perPage): array
    {
        return VehicleModel::skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->map(fn ($m) => VehicleMapper::toDomain($m))
            ->all();
    }

    public function countAll(): int
    {
        return VehicleModel::count();
    }
}
