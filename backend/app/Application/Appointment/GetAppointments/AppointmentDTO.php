<?php

declare(strict_types=1);

namespace App\Application\Appointment\GetAppointments;

final readonly class AppointmentDTO
{
    public function __construct(
        public int $id,
        public int $vehicle_id,
        public int $technician_id,
        public int $work_station_id,
        public string $scheduled_at,
        public int $duration_minutes,
        public string $status,
        public ?string $notes,
    ) {}
}
