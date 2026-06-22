<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\BlockedPeriod\BlockedPeriod;
use App\Domain\BlockedPeriod\ValueObjects\BlockedPeriodId;
use App\Domain\Location\ValueObjects\LocationId;
use App\Infrastructure\Persistence\Eloquent\Models\BlockedPeriodModel;

final class BlockedPeriodMapper
{
    public static function toDomain(BlockedPeriodModel $model): BlockedPeriod
    {
        return BlockedPeriod::create(
            new BlockedPeriodId((int) $model->id),
            new LocationId((int) $model->location_id),
            \DateTimeImmutable::createFromMutable($model->starts_at->toDateTime()),
            \DateTimeImmutable::createFromMutable($model->ends_at->toDateTime()),
            $model->reason,
        );
    }

    public static function toModel(BlockedPeriod $period): array
    {
        return [
            'location_id' => $period->locationId()->value,
            'starts_at'   => $period->startsAt()->format('Y-m-d H:i:s'),
            'ends_at'     => $period->endsAt()->format('Y-m-d H:i:s'),
            'reason'      => $period->reason(),
        ];
    }
}
