<?php

declare(strict_types=1);

namespace App\Application\Appointment\UpdateAppointmentStatus;

final readonly class UpdateAppointmentStatusCommand
{
    public function __construct(
        public string $appointmentId,
        public string $status,
    ) {}
}
