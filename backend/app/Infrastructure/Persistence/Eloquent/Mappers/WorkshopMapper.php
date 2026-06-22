<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Workshop\ValueObjects\CostCenter;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\Workshop\ValueObjects\WorkshopName;
use App\Domain\Workshop\Workshop;
use App\Infrastructure\Persistence\Eloquent\Models\WorkshopModel;

final class WorkshopMapper
{
    public static function toDomain(WorkshopModel $model): Workshop
    {
        return Workshop::create(
            new WorkshopId((int) $model->id),
            new WorkshopName($model->name),
            $model->address,
            new CostCenter($model->cost_center),
        );
    }

    public static function toModel(Workshop $workshop): array
    {
        return [
            'name'        => $workshop->name()->value,
            'address'     => $workshop->address(),
            'cost_center' => $workshop->costCenter()->value,
        ];
    }
}
