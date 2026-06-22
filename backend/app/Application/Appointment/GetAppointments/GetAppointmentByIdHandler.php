<?php

declare(strict_types=1);

namespace App\Application\Appointment\GetAppointments;

use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use RuntimeException;

final class GetAppointmentByIdHandler
{
    public function __construct(
        private readonly IAppointmentRepository $appointments,
    ) {}

    public function handle(string $id): AppointmentDTO
    {
        $appointment = $this->appointments->findById(new AppointmentId((int) $id));

        if ($appointment === null) {
            throw new RuntimeException("Appointment [{$id}] not found.");
        }

        return new AppointmentDTO(
            id: $appointment->id()->value,
            vehicle_id: $appointment->vehicleId()->value,
            technician_id: $appointment->technicianId()->value,
            work_station_id: $appointment->workStationId()->value,
            scheduled_at: $appointment->scheduledAt()->format(\DateTimeInterface::ATOM),
            duration_minutes: $appointment->durationMinutes(),
            status: $appointment->status()->value,
            notes: $appointment->notes(),
        );
    }
}
