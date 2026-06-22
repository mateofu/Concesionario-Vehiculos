<?php

declare(strict_types=1);

namespace App\Domain\Appointment\Events;

use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;

final class AppointmentStatusUpdated
{
    public function __construct(
        public readonly AppointmentId $appointmentId,
        public readonly AppointmentStatus $previousStatus,
        public readonly AppointmentStatus $newStatus,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}
