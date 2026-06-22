<?php

declare(strict_types=1);

namespace App\Application\OperatingSchedule\SetSchedule;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\IOperatingScheduleRepository;
use App\Domain\OperatingSchedule\OperatingSchedule;
use App\Domain\OperatingSchedule\ValueObjects\OperatingScheduleId;
use RuntimeException;

final class SetOperatingScheduleHandler
{
    public function __construct(
        private readonly IOperatingScheduleRepository $schedules,
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(SetOperatingScheduleCommand $command): int
    {
        $locationId = new LocationId((int) $command->locationId);

        if ($this->locations->findById($locationId) === null) {
            throw new RuntimeException("Location [{$command->locationId}] not found.");
        }

        $existing = $this->schedules->findByLocationAndDay($locationId, $command->dayOfWeek);
        $id       = $existing ? $existing->id() : new OperatingScheduleId(0);

        $schedule = OperatingSchedule::create(
            $id,
            $locationId,
            $command->dayOfWeek,
            $command->opensAt,
            $command->closesAt,
            $command->isClosed,
        );

        return $this->schedules->save($schedule);
    }
}
