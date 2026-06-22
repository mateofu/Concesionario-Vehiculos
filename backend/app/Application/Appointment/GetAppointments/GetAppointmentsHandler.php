<?php

declare(strict_types=1);

namespace App\Application\Appointment\GetAppointments;

use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;

final class GetAppointmentsHandler
{
    public function __construct(
        private readonly IAppointmentRepository $appointments,
    ) {}

    /** @return AppointmentDTO[] */
    public function handle(
        ?string $status = null,
        ?string $technicianId = null,
        ?string $vehicleId = null,
        ?string $date = null,
    ): array {
        $appointments = $this->appointments->findAll(
            status: $status !== null ? AppointmentStatus::from($status) : null,
            technicianId: $technicianId !== null ? new TechnicianId($technicianId) : null,
            vehicleId: $vehicleId !== null ? new VehicleId($vehicleId) : null,
            date: $date !== null ? new \DateTimeImmutable($date) : null,
        );

        return array_map(
            fn ($appointment) => new AppointmentDTO(
                id: $appointment->id()->value,
                vehicle_id: $appointment->vehicleId()->value,
                technician_id: $appointment->technicianId()->value,
                work_station_id: $appointment->workStationId()->value,
                scheduled_at: $appointment->scheduledAt()->format(\DateTimeInterface::ATOM),
                status: $appointment->status()->value,
                notes: $appointment->notes(),
            ),
            $appointments,
        );
    }
}
