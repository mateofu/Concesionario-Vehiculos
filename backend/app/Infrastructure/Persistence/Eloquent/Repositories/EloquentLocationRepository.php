<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Infrastructure\Persistence\Eloquent\Mappers\LocationMapper;
use App\Infrastructure\Persistence\Eloquent\Models\LocationModel;

final class EloquentLocationRepository implements ILocationRepository
{
    public function save(Location $location): int
    {
        $model = LocationModel::create(LocationMapper::toModel($location));

        return $model->id;
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

    public function findPaginated(int $page, int $perPage): array
    {
        return LocationModel::skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->map(fn ($m) => LocationMapper::toDomain($m))
            ->all();
    }

    public function countAll(): int
    {
        return LocationModel::count();
    }
}
