<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\OperatingSchedule;
use App\Domain\OperatingSchedule\ValueObjects\OperatingScheduleId;
use App\Infrastructure\Persistence\Eloquent\Models\OperatingScheduleModel;

final class OperatingScheduleMapper
{
    public static function toDomain(OperatingScheduleModel $model): OperatingSchedule
    {
        return OperatingSchedule::create(
            new OperatingScheduleId((int) $model->id),
            new LocationId((int) $model->location_id),
            (int) $model->day_of_week,
            substr($model->opens_at, 0, 5),
            substr($model->closes_at, 0, 5),
            (bool) $model->is_closed,
        );
    }

    public static function toModel(OperatingSchedule $schedule): array
    {
        return [
            'location_id' => $schedule->locationId()->value,
            'day_of_week' => $schedule->dayOfWeek(),
            'opens_at'    => $schedule->opensAt(),
            'closes_at'   => $schedule->closesAt(),
            'is_closed'   => $schedule->isClosed(),
        ];
    }
}
