<?php

declare(strict_types=1);

namespace App\Domain\Appointment;

use App\Domain\Appointment\Events\AppointmentCancelled;
use App\Domain\Appointment\Events\AppointmentStatusUpdated;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use DomainException;

final class Appointment
{
    /** @var object[] */
    private array $domainEvents = [];

    private function __construct(
        private readonly AppointmentId $id,
        private readonly VehicleId $vehicleId,
        private readonly TechnicianId $technicianId,
        private readonly WorkStationId $workStationId,
        private readonly \DateTimeImmutable $scheduledAt,
        private AppointmentStatus $status,
        private ?string $notes,
    ) {}

    public static function create(
        AppointmentId $id,
        VehicleId $vehicleId,
        TechnicianId $technicianId,
        WorkStationId $workStationId,
        \DateTimeImmutable $scheduledAt,
        ?string $notes = null,
    ): self {
        $appointment = new self(
            $id,
            $vehicleId,
            $technicianId,
            $workStationId,
            $scheduledAt,
            AppointmentStatus::PENDING,
            $notes,
        );

        return $appointment;
    }

    public static function reconstitute(
        AppointmentId $id,
        VehicleId $vehicleId,
        TechnicianId $technicianId,
        WorkStationId $workStationId,
        \DateTimeImmutable $scheduledAt,
        AppointmentStatus $status,
        ?string $notes,
    ): self {
        return new self($id, $vehicleId, $technicianId, $workStationId, $scheduledAt, $status, $notes);
    }

    public function updateStatus(AppointmentStatus $newStatus): void
    {
        if (!$this->status->canTransitionTo($newStatus)) {
            throw new DomainException(
                "Cannot transition appointment from [{$this->status->value}] to [{$newStatus->value}]."
            );
        }

        $previous = $this->status;
        $this->status = $newStatus;

        $this->domainEvents[] = new AppointmentStatusUpdated(
            $this->id,
            $previous,
            $newStatus,
            new \DateTimeImmutable(),
        );
    }

    public function cancel(): void
    {
        $this->updateStatus(AppointmentStatus::CANCELLED);

        $this->domainEvents[] = new AppointmentCancelled($this->id, new \DateTimeImmutable());
    }

    public function id(): AppointmentId
    {
        return $this->id;
    }

    public function vehicleId(): VehicleId
    {
        return $this->vehicleId;
    }

    public function technicianId(): TechnicianId
    {
        return $this->technicianId;
    }

    public function workStationId(): WorkStationId
    {
        return $this->workStationId;
    }

    public function scheduledAt(): \DateTimeImmutable
    {
        return $this->scheduledAt;
    }

    public function status(): AppointmentStatus
    {
        return $this->status;
    }

    public function notes(): ?string
    {
        return $this->notes;
    }

    /** @return object[] */
    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }
}
