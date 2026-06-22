<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Infrastructure\Persistence\Eloquent\Models\LocationModel;

final class LocationMapper
{
    public static function toDomain(LocationModel $model): Location
    {
        return Location::create(
            new LocationId($model->id),
            new LocationName($model->name),
            $model->address,
            new WorkshopId($model->workshop_id),
        );
    }

    public static function toModel(Location $location): array
    {
        return [
            'id'          => $location->id()->value,
            'workshop_id' => $location->workshopId()->value,
            'name'        => $location->name()->value,
            'address'     => $location->address(),
        ];
    }
}
