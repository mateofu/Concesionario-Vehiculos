<?php

declare(strict_types=1);

namespace App\Application\Appointment\CancelAppointment;

final readonly class CancelAppointmentCommand
{
    public function __construct(
        public string $appointmentId,
    ) {}
}
