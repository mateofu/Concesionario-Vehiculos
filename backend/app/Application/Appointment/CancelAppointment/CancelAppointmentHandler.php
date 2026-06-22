<?php

declare(strict_types=1);

namespace App\Application\Appointment\CancelAppointment;

use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use RuntimeException;

final class CancelAppointmentHandler
{
    public function __construct(
        private readonly IAppointmentRepository $appointments,
    ) {}

    public function handle(string $appointmentId): void
    {
        $appointment = $this->appointments->findById(new AppointmentId((int) $appointmentId));

        if ($appointment === null) {
            throw new RuntimeException("Appointment [{$appointmentId}] not found.");
        }

        $appointment->cancel();

        $this->appointments->update($appointment);
    }
}
