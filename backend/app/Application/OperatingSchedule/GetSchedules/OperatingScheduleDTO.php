<?php

declare(strict_types=1);

namespace App\Application\OperatingSchedule\GetSchedules;

final readonly class OperatingScheduleDTO
{
    public function __construct(
        public int $id,
        public int $location_id,
        public int $day_of_week,
        public string $opens_at,
        public string $closes_at,
        public bool $is_closed,
    ) {}
}
