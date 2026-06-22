<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;
use App\Domain\WorkStation\WorkStation;
use App\Infrastructure\Persistence\Eloquent\Models\WorkStationModel;

final class WorkStationMapper
{
    public static function toDomain(WorkStationModel $model): WorkStation
    {
        return WorkStation::create(
            new WorkStationId($model->id),
            new WorkStationName($model->name),
            new LocationId($model->location_id),
        );
    }

    public static function toModel(WorkStation $workStation): array
    {
        return [
            'id'          => $workStation->id()->value,
            'location_id' => $workStation->locationId()->value,
            'name'        => $workStation->name()->value,
        ];
    }
}
