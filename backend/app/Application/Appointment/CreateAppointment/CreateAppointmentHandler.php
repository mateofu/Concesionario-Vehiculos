<?php

declare(strict_types=1);

namespace App\Application\Appointment\CreateAppointment;

use App\Domain\Appointment\Appointment;
use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use Illuminate\Support\Str;
use RuntimeException;

final class CreateAppointmentHandler
{
    public function __construct(
        private readonly IAppointmentRepository $appointments,
        private readonly IVehicleRepository $vehicles,
        private readonly ITechnicianRepository $technicians,
        private readonly IWorkStationRepository $workStations,
    ) {}

    public function handle(CreateAppointmentCommand $command): string
    {
        $vehicleId     = new VehicleId($command->vehicleId);
        $technicianId  = new TechnicianId($command->technicianId);
        $workStationId = new WorkStationId($command->workStationId);
        $scheduledAt   = new \DateTimeImmutable($command->scheduledAt);

        if ($this->vehicles->findById($vehicleId) === null) {
            throw new RuntimeException("Vehicle [{$command->vehicleId}] not found.");
        }

        if ($this->technicians->findById($technicianId) === null) {
            throw new RuntimeException("Technician [{$command->technicianId}] not found.");
        }

        if ($this->workStations->findById($workStationId) === null) {
            throw new RuntimeException("WorkStation [{$command->workStationId}] not found.");
        }

        if ($this->appointments->hasOverlap($workStationId, $scheduledAt, $command->durationMinutes)) {
            throw new RuntimeException(
                "WorkStation [{$command->workStationId}] already has an appointment in that time slot."
            );
        }

        $id = new AppointmentId((string) Str::uuid());

        $appointment = Appointment::create(
            $id,
            $vehicleId,
            $technicianId,
            $workStationId,
            $scheduledAt,
            $command->durationMinutes,
            $command->notes,
        );

        $this->appointments->save($appointment);

        return $id->value;
    }
}
