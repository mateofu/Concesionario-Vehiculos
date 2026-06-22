<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Infrastructure\Persistence\Eloquent\Mappers\LocationMapper;
use App\Infrastructure\Persistence\Eloquent\Models\LocationModel;

final class EloquentLocationRepository implements ILocationRepository
{
    public function save(Location $location): void
    {
        LocationModel::updateOrCreate(
            ['id' => $location->id()->value],
            LocationMapper::toModel($location),
        );
    }

    public function findById(LocationId $id): ?Location
    {
        $model = LocationModel::find($id->value);

        return $model ? LocationMapper::toDomain($model) : null;
    }

    public function findAll(): array
    {
        return LocationModel::all()
            ->map(fn ($m) => LocationMapper::toDomain($m))
            ->all();
    }

    public function findByWorkshop(WorkshopId $workshopId): array
    {
        return LocationModel::where('workshop_id', $workshopId->value)
            ->get()
            ->map(fn ($m) => LocationMapper::toDomain($m))
            ->all();
    }
}
