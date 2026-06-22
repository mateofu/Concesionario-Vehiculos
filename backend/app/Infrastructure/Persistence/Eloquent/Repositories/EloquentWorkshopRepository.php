<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

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
}
