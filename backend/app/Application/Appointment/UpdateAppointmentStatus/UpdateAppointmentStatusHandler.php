<?php

declare(strict_types=1);

namespace App\Application\Appointment\UpdateAppointmentStatus;

use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use RuntimeException;

final class UpdateAppointmentStatusHandler
{
    public function __construct(
        private readonly IAppointmentRepository $appointments,
    ) {}

    public function handle(UpdateAppointmentStatusCommand $command): void
    {
        $appointment = $this->appointments->findById(new AppointmentId((int) $command->appointmentId));

        if ($appointment === null) {
            throw new RuntimeException("Appointment [{$command->appointmentId}] not found.");
        }

        $appointment->updateStatus(AppointmentStatus::from($command->status));

        $this->appointments->update($appointment);
    }
}
