<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\WorkStation\ValueObjects\TechnicalArea;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;
use App\Domain\WorkStation\WorkStation;
use App\Infrastructure\Persistence\Eloquent\Models\WorkStationModel;

final class WorkStationMapper
{
    public static function toDomain(WorkStationModel $model): WorkStation
    {
        return WorkStation::create(
            new WorkStationId((int) $model->id),
            new WorkStationName($model->name),
            new WorkshopId((int) $model->workshop_id),
            (int) $model->station_number,
            new TechnicalArea($model->technical_area),
        );
    }

    public static function toModel(WorkStation $workStation): array
    {
        return [
            'workshop_id'    => $workStation->workshopId()->value,
            'name'           => $workStation->name()->value,
            'station_number' => $workStation->stationNumber(),
            'technical_area' => $workStation->technicalArea()->value,
        ];
    }
}
