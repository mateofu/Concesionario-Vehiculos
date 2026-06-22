<?php

declare(strict_types=1);

namespace App\Application\OperatingSchedule\SetSchedule;

final readonly class SetOperatingScheduleCommand
{
    public function __construct(
        public string $locationId,
        public int $dayOfWeek,
        public string $opensAt,
        public string $closesAt,
        public bool $isClosed = false,
    ) {}
}
