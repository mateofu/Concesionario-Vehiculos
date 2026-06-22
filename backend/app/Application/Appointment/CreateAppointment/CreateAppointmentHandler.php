<?php

declare(strict_types=1);

namespace App\Application\Appointment\CreateAppointment;

use App\Domain\Appointment\Appointment;
use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\BlockedPeriod\IBlockedPeriodRepository;
use App\Domain\OperatingSchedule\IOperatingScheduleRepository;
use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use RuntimeException;

final class CreateAppointmentHandler
{
    public function __construct(
        private readonly IAppointmentRepository $appointments,
        private readonly IVehicleRepository $vehicles,
        private readonly ITechnicianRepository $technicians,
        private readonly IWorkStationRepository $workStations,
        private readonly IOperatingScheduleRepository $operatingSchedules,
        private readonly IBlockedPeriodRepository $blockedPeriods,
    ) {}

    public function handle(CreateAppointmentCommand $command): int
    {
        $vehicleId     = new VehicleId((int) $command->vehicleId);
        $technicianId  = new TechnicianId((int) $command->technicianId);
        $workStationId = new WorkStationId((int) $command->workStationId);
        $scheduledAt   = new \DateTimeImmutable($command->scheduledAt);

        if ($this->vehicles->findById($vehicleId) === null) {
            throw new RuntimeException("Vehicle [{$command->vehicleId}] not found.");
        }

        if ($this->technicians->findById($technicianId) === null) {
            throw new RuntimeException("Technician [{$command->technicianId}] not found.");
        }

        $workStation = $this->workStations->findById($workStationId);
        if ($workStation === null) {
            throw new RuntimeException("WorkStation [{$command->workStationId}] not found.");
        }

        $locationId = $workStation->locationId();
        $dayOfWeek  = (int) $scheduledAt->format('N');

        $schedule = $this->operatingSchedules->findByLocationAndDay($locationId, $dayOfWeek);

        if ($schedule === null) {
            throw new RuntimeException(
                "No operating schedule configured for that location on day [{$dayOfWeek}]."
            );
        }

        if (!$schedule->containsSlot($scheduledAt, $command->durationMinutes)) {
            $status = $schedule->isClosed() ? 'closed' : "open {$schedule->opensAt()}–{$schedule->closesAt()}";
            throw new RuntimeException(
                "Appointment falls outside operating hours ({$status})."
            );
        }

        if ($this->blockedPeriods->hasOverlap($locationId, $scheduledAt, $command->durationMinutes)) {
            throw new RuntimeException(
                "Location is unavailable during the requested time period."
            );
        }

        if ($this->appointments->hasOverlap($workStationId, $scheduledAt, $command->durationMinutes)) {
            throw new RuntimeException(
                "WorkStation [{$command->workStationId}] already has an appointment in that time slot."
            );
        }

        $appointment = Appointment::create(
            new AppointmentId(0),
            $vehicleId,
            $technicianId,
            $workStationId,
            $scheduledAt,
            $command->durationMinutes,
            $command->notes,
        );

        return $this->appointments->save($appointment);
    }
}
