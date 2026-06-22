<?php

declare(strict_types=1);

namespace App\Domain\OperatingSchedule;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\ValueObjects\OperatingScheduleId;

interface IOperatingScheduleRepository
{
    public function save(OperatingSchedule $schedule): int;

    public function findById(OperatingScheduleId $id): ?OperatingSchedule;

    /** @return OperatingSchedule[] */
    public function findByLocation(LocationId $locationId): array;

    public function findByLocationAndDay(LocationId $locationId, int $dayOfWeek): ?OperatingSchedule;
}
