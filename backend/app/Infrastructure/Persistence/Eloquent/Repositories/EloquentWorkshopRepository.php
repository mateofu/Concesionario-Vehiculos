<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Workshop\IWorkshopRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\Workshop\Workshop;
use App\Infrastructure\Persistence\Eloquent\Mappers\WorkshopMapper;
use App\Infrastructure\Persistence\Eloquent\Models\WorkshopModel;

final class EloquentWorkshopRepository implements IWorkshopRepository
{
    public function save(Workshop $workshop): int
    {
        $model = WorkshopModel::create(WorkshopMapper::toModel($workshop));

        return $model->id;
    }

    public function findById(WorkshopId $id): ?Workshop
    {
        $model = WorkshopModel::find($id->value);

        return $model ? WorkshopMapper::toDomain($model) : null;
    }

    public function findAll(): array
    {
        return WorkshopModel::all()
            ->map(fn ($m) => WorkshopMapper::toDomain($m))
            ->all();
    }

    public function findByLocation(LocationId $locationId): array
    {
        return WorkshopModel::where('location_id', $locationId->value)
            ->get()
            ->map(fn ($m) => WorkshopMapper::toDomain($m))
            ->all();
    }

    public function findPaginated(int $page, int $perPage, ?LocationId $locationId = null): array
    {
        $query = WorkshopModel::query();

        if ($locationId !== null) {
            $query->where('location_id', $locationId->value);
        }

        return $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->map(fn ($m) => WorkshopMapper::toDomain($m))
            ->all();
    }

    public function countAll(?LocationId $locationId = null): int
    {
        $query = WorkshopModel::query();

        if ($locationId !== null) {
            $query->where('location_id', $locationId->value);
        }

        return $query->count();
    }
}
