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

    public function handle(CancelAppointmentCommand $command): void
    {
        $id = new AppointmentId($command->appointmentId);

        $appointment = $this->appointments->findById($id);

        if ($appointment === null) {
            throw new RuntimeException("Appointment [{$command->appointmentId}] not found.");
        }

        $appointment->cancel();

        $this->appointments->save($appointment);
    }
}
