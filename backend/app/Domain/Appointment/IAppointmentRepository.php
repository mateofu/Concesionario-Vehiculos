<?php

declare(strict_types=1);

namespace App\Domain\Appointment;

use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;

interface IAppointmentRepository
{
    public function save(Appointment $appointment): void;

    public function findById(AppointmentId $id): ?Appointment;

    /**
     * @param  AppointmentStatus|null $status
     * @param  TechnicianId|null      $technicianId
     * @param  VehicleId|null         $vehicleId
     * @param  \DateTimeImmutable|null $date  filter by calendar date (ignores time)
     * @return Appointment[]
     */
    public function findAll(
        ?AppointmentStatus $status = null,
        ?TechnicianId $technicianId = null,
        ?VehicleId $vehicleId = null,
        ?\DateTimeImmutable $date = null,
    ): array;
}
