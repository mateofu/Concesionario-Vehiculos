<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\IOperatingScheduleRepository;
use App\Domain\OperatingSchedule\OperatingSchedule;
use App\Domain\OperatingSchedule\ValueObjects\OperatingScheduleId;
use App\Infrastructure\Persistence\Eloquent\Mappers\OperatingScheduleMapper;
use App\Infrastructure\Persistence\Eloquent\Models\OperatingScheduleModel;

final class EloquentOperatingScheduleRepository implements IOperatingScheduleRepository
{
    public function save(OperatingSchedule $schedule): int
    {
        if ($schedule->id()->value > 0) {
            OperatingScheduleModel::where('id', $schedule->id()->value)
                ->update(OperatingScheduleMapper::toModel($schedule));

            return $schedule->id()->value;
        }

        $model = OperatingScheduleModel::create(OperatingScheduleMapper::toModel($schedule));

        return $model->id;
    }

    public function findById(OperatingScheduleId $id): ?OperatingSchedule
    {
        $model = OperatingScheduleModel::find($id->value);

        return $model ? OperatingScheduleMapper::toDomain($model) : null;
    }

    public function findByLocation(LocationId $locationId): array
    {
        return OperatingScheduleModel::where('location_id', $locationId->value)
            ->orderBy('day_of_week')
            ->get()
            ->map(fn ($m) => OperatingScheduleMapper::toDomain($m))
            ->all();
    }

    public function findByLocationAndDay(LocationId $locationId, int $dayOfWeek): ?OperatingSchedule
    {
        $model = OperatingScheduleModel::where('location_id', $locationId->value)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        return $model ? OperatingScheduleMapper::toDomain($model) : null;
    }
}
