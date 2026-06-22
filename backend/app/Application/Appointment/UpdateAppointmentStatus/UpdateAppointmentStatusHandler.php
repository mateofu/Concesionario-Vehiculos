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
        $id = new AppointmentId($command->appointmentId);

        $appointment = $this->appointments->findById($id);

        if ($appointment === null) {
            throw new RuntimeException("Appointment [{$command->appointmentId}] not found.");
        }

        $newStatus = AppointmentStatus::from($command->status);

        $appointment->updateStatus($newStatus);

        $this->appointments->save($appointment);
    }
}
