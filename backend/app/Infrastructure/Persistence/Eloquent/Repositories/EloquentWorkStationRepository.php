<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\WorkStation;
use App\Infrastructure\Persistence\Eloquent\Mappers\WorkStationMapper;
use App\Infrastructure\Persistence\Eloquent\Models\WorkStationModel;

final class EloquentWorkStationRepository implements IWorkStationRepository
{
    public function save(WorkStation $workStation): int
    {
        $model = WorkStationModel::create(WorkStationMapper::toModel($workStation));

        return $model->id;
    }

    public function findById(WorkStationId $id): ?WorkStation
    {
        $model = WorkStationModel::find($id->value);

        return $model ? WorkStationMapper::toDomain($model) : null;
    }

    public function findByLocation(LocationId $locationId): array
    {
        return WorkStationModel::where('location_id', $locationId->value)
            ->get()
            ->map(fn ($m) => WorkStationMapper::toDomain($m))
            ->all();
    }

    public function findAll(): array
    {
        return WorkStationModel::all()
            ->map(fn ($m) => WorkStationMapper::toDomain($m))
            ->all();
    }

    public function assignTechnician(WorkStationId $workStationId, TechnicianId $technicianId): void
    {
        $model = WorkStationModel::findOrFail($workStationId->value);

        $model->technicians()->syncWithoutDetaching([$technicianId->value]);
    }
}
