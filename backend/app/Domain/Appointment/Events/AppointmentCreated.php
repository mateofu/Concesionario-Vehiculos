<?php

declare(strict_types=1);

namespace App\Domain\Appointment\Events;

use App\Domain\Appointment\ValueObjects\AppointmentId;

final class AppointmentCreated
{
    public function __construct(
        public readonly AppointmentId $appointmentId,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}
