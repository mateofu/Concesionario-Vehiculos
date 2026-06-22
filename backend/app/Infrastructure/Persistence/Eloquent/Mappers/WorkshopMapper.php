<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\Workshop\ValueObjects\WorkshopName;
use App\Domain\Workshop\Workshop;
use App\Infrastructure\Persistence\Eloquent\Models\WorkshopModel;

final class WorkshopMapper
{
    public static function toDomain(WorkshopModel $model): Workshop
    {
        return Workshop::create(
            new WorkshopId($model->id),
            new WorkshopName($model->name),
            $model->address,
        );
    }

    public static function toModel(Workshop $workshop): array
    {
        return [
            'id'      => $workshop->id()->value,
            'name'    => $workshop->name()->value,
            'address' => $workshop->address(),
        ];
    }
}
