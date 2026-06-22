<?php

declare(strict_types=1);

namespace App\Domain\Appointment\ValueObjects;

enum AppointmentStatus: string
{
    case PROGRAMADA  = 'programada';
    case CONFIRMADA  = 'confirmada';
    case ATENDIDA    = 'atendida';
    case CANCELADA   = 'cancelada';

    /** @return AppointmentStatus[] */
    public function allowedTransitions(): array
    {
        return match($this) {
            self::PROGRAMADA => [self::CONFIRMADA, self::CANCELADA],
            self::CONFIRMADA => [self::ATENDIDA, self::CANCELADA],
            self::ATENDIDA   => [],
            self::CANCELADA  => [],
        };
    }

    public function canTransitionTo(self $next): bool
    {
        return in_array($next, $this->allowedTransitions(), true);
    }
}
