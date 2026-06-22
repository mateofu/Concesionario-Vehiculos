<?php

declare(strict_types=1);

namespace App\Domain\Appointment;

use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\WorkStation\ValueObjects\WorkStationId;

interface IAppointmentRepository
{
    public function save(Appointment $appointment): int;

    public function update(Appointment $appointment): void;

    public function findById(AppointmentId $id): ?Appointment;

    /** @return Appointment[] */
    public function findAll(
        ?AppointmentStatus $status = null,
        ?TechnicianId $technicianId = null,
        ?VehicleId $vehicleId = null,
        ?\DateTimeImmutable $date = null,
    ): array;

    public function findPaginated(
        int $page,
        int $perPage,
        ?AppointmentStatus $status = null,
        ?TechnicianId $technicianId = null,
        ?VehicleId $vehicleId = null,
        ?\DateTimeImmutable $date = null,
    ): array;

    public function countAll(
        ?AppointmentStatus $status = null,
        ?TechnicianId $technicianId = null,
        ?VehicleId $vehicleId = null,
        ?\DateTimeImmutable $date = null,
    ): int;

    public function hasOverlap(
        WorkStationId $workStationId,
        \DateTimeImmutable $start,
        int $durationMinutes,
        ?AppointmentId $excludeId = null,
    ): bool;
}
