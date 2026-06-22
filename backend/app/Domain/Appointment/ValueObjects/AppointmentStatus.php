<?php

declare(strict_types=1);

namespace App\Domain\Appointment\ValueObjects;

enum AppointmentStatus: string
{
    case PENDING     = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED   = 'completed';
    case CANCELLED   = 'cancelled';

    /** @return AppointmentStatus[] */
    public function allowedTransitions(): array
    {
        return match($this) {
            self::PENDING     => [self::IN_PROGRESS, self::CANCELLED],
            self::IN_PROGRESS => [self::COMPLETED, self::CANCELLED],
            self::COMPLETED   => [],
            self::CANCELLED   => [],
        };
    }

    public function canTransitionTo(self $next): bool
    {
        return in_array($next, $this->allowedTransitions(), true);
    }
}
