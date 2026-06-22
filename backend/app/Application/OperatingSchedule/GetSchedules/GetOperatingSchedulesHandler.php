<?php

declare(strict_types=1);

namespace App\Application\OperatingSchedule\GetSchedules;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\IOperatingScheduleRepository;

final class GetOperatingSchedulesHandler
{
    public function __construct(
        private readonly IOperatingScheduleRepository $schedules,
    ) {}

    /** @return OperatingScheduleDTO[] */
    public function handle(string $locationId): array
    {
        $schedules = $this->schedules->findByLocation(new LocationId((int) $locationId));

        return array_map(
            fn ($s) => new OperatingScheduleDTO(
                id: $s->id()->value,
                location_id: $s->locationId()->value,
                day_of_week: $s->dayOfWeek(),
                opens_at: $s->opensAt(),
                closes_at: $s->closesAt(),
                is_closed: $s->isClosed(),
            ),
            $schedules,
        );
    }
}
