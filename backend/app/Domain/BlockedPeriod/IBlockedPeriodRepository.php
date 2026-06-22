<?php

declare(strict_types=1);

namespace App\Domain\BlockedPeriod;

use App\Domain\BlockedPeriod\ValueObjects\BlockedPeriodId;
use App\Domain\Location\ValueObjects\LocationId;

interface IBlockedPeriodRepository
{
    public function save(BlockedPeriod $period): int;

    public function findById(BlockedPeriodId $id): ?BlockedPeriod;

    /** @return BlockedPeriod[] */
    public function findByLocation(LocationId $locationId): array;

    public function hasOverlap(
        LocationId $locationId,
        \DateTimeImmutable $start,
        int $durationMinutes,
    ): bool;
}
