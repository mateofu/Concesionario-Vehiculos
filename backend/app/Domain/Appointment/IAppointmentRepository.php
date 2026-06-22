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
    public function save(Appointment $appointment): void;

    public function findById(AppointmentId $id): ?Appointment;

    /**
     * @return Appointment[]
     */
    public function findAll(
        ?AppointmentStatus $status = null,
        ?TechnicianId $technicianId = null,
        ?VehicleId $vehicleId = null,
        ?\DateTimeImmutable $date = null,
    ): array;

    /**
     * Returns true if there is an existing active appointment at the given work station
     * that overlaps with the proposed time slot [start, start + durationMinutes).
     */
    public function hasOverlap(
        WorkStationId $workStationId,
        \DateTimeImmutable $start,
        int $durationMinutes,
        ?AppointmentId $excludeId = null,
    ): bool;
}
