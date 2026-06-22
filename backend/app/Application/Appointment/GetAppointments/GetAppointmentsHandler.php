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
            fn ($a) => new AppointmentDTO(
                id: $a->id()->value,
                vehicle_id: $a->vehicleId()->value,
                technician_id: $a->technicianId()->value,
                work_station_id: $a->workStationId()->value,
                scheduled_at: $a->scheduledAt()->format(\DateTimeInterface::ATOM),
                duration_minutes: $a->durationMinutes(),
                status: $a->status()->value,
                notes: $a->notes(),
            ),
            $appointments,
        );
    }
}
