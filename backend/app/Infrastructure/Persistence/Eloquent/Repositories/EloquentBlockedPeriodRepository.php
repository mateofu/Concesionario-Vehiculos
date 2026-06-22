<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\BlockedPeriod\BlockedPeriod;
use App\Domain\BlockedPeriod\IBlockedPeriodRepository;
use App\Domain\BlockedPeriod\ValueObjects\BlockedPeriodId;
use App\Domain\Location\ValueObjects\LocationId;
use App\Infrastructure\Persistence\Eloquent\Mappers\BlockedPeriodMapper;
use App\Infrastructure\Persistence\Eloquent\Models\BlockedPeriodModel;

final class EloquentBlockedPeriodRepository implements IBlockedPeriodRepository
{
    public function save(BlockedPeriod $period): int
    {
        $model = BlockedPeriodModel::create(BlockedPeriodMapper::toModel($period));

        return $model->id;
    }

    public function findById(BlockedPeriodId $id): ?BlockedPeriod
    {
        $model = BlockedPeriodModel::find($id->value);

        return $model ? BlockedPeriodMapper::toDomain($model) : null;
    }

    public function findByLocation(LocationId $locationId): array
    {
        return BlockedPeriodModel::where('location_id', $locationId->value)
            ->orderBy('starts_at')
            ->get()
            ->map(fn ($m) => BlockedPeriodMapper::toDomain($m))
            ->all();
    }

    public function hasOverlap(
        LocationId $locationId,
        \DateTimeImmutable $start,
        int $durationMinutes,
    ): bool {
        $end = $start->modify("+{$durationMinutes} minutes");

        return BlockedPeriodModel::where('location_id', $locationId->value)
            ->where('starts_at', '<', $end->format('Y-m-d H:i:s'))
            ->where('ends_at', '>', $start->format('Y-m-d H:i:s'))
            ->exists();
    }
}
