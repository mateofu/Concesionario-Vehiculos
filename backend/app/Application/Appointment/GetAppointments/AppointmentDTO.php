<?php

declare(strict_types=1);

namespace App\Application\Appointment\GetAppointments;

final readonly class AppointmentDTO
{
    public function __construct(
        public string $id,
        public string $vehicleId,
        public string $technicianId,
        public string $workStationId,
        public string $scheduledAt,
        public string $status,
        public ?string $notes,
    ) {}
}
