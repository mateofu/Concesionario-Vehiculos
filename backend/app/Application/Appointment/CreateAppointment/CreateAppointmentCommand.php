<?php

declare(strict_types=1);

namespace App\Application\Appointment\CreateAppointment;

final readonly class CreateAppointmentCommand
{
    public function __construct(
        public string $vehicleId,
        public string $technicianId,
        public string $workStationId,
        public string $scheduledAt,
        public ?string $notes = null,
    ) {}
}
