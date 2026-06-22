<?php

declare(strict_types=1);

namespace App\Application\Appointment\GetAppointments;

use App\Application\Shared\PaginatedResult;
use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;

final class GetAppointmentsHandler
{
    public function __construct(
        private readonly IAppointmentRepository $appointments,
    ) {}

    public function handle(
        ?string $status = null,
        ?string $technicianId = null,
        ?string $vehicleId = null,
        ?string $date = null,
        int $page = 1,
        int $perPage = 15,
    ): PaginatedResult {
        $statusVO      = $status !== null ? AppointmentStatus::from($status) : null;
        $technicianVO  = $technicianId !== null ? new TechnicianId((int) $technicianId) : null;
        $vehicleVO     = $vehicleId !== null ? new VehicleId((int) $vehicleId) : null;
        $dateVO        = $date !== null ? new \DateTimeImmutable($date) : null;

        $items = array_map(
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
            $this->appointments->findPaginated($page, $perPage, $statusVO, $technicianVO, $vehicleVO, $dateVO),
        );

        return new PaginatedResult(
            items: $items,
            total: $this->appointments->countAll($statusVO, $technicianVO, $vehicleVO, $dateVO),
            page: $page,
            perPage: $perPage,
        );
    }
}
