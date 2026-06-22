<?php

declare(strict_types=1);

namespace App\Application\BlockedPeriod\GetBlockedPeriods;

final readonly class BlockedPeriodDTO
{
    public function __construct(
        public int $id,
        public int $location_id,
        public string $starts_at,
        public string $ends_at,
        public ?string $reason,
    ) {}
}
