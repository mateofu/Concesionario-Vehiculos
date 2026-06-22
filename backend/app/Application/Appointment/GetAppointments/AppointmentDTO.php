<?php

declare(strict_types=1);

namespace App\Application\Appointment\GetAppointments;

final readonly class AppointmentDTO
{
    public function __construct(
        public string $id,
        public string $vehicle_id,
        public string $technician_id,
        public string $work_station_id,
        public string $scheduled_at,
        public int $duration_minutes,
        public string $status,
        public ?string $notes,
    ) {}
}
