<?php

declare(strict_types=1);

namespace App\Application\BlockedPeriod\CreateBlockedPeriod;

final readonly class CreateBlockedPeriodCommand
{
    public function __construct(
        public string $locationId,
        public string $startsAt,
        public string $endsAt,
        public ?string $reason = null,
    ) {}
}
