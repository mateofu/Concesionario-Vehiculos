<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;
use App\Infrastructure\Persistence\Eloquent\Models\LocationModel;

final class LocationMapper
{
    public static function toDomain(LocationModel $model): Location
    {
        return Location::create(
            new LocationId((int) $model->id),
            new LocationName($model->name),
            $model->address,
        );
    }

    public static function toModel(Location $location): array
    {
        return [
            'name'    => $location->name()->value,
            'address' => $location->address(),
        ];
    }
}
