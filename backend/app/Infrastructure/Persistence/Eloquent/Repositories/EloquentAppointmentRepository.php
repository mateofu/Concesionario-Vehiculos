<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Appointment\Appointment;
use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Infrastructure\Persistence\Eloquent\Mappers\AppointmentMapper;
use App\Infrastructure\Persistence\Eloquent\Models\AppointmentModel;

final class EloquentAppointmentRepository implements IAppointmentRepository
{
    public function save(Appointment $appointment): void
    {
        AppointmentModel::updateOrCreate(
            ['id' => $appointment->id()->value],
            AppointmentMapper::toModel($appointment),
        );
    }

    public function findById(AppointmentId $id): ?Appointment
    {
        $model = AppointmentModel::find($id->value);

        return $model ? AppointmentMapper::toDomain($model) : null;
    }

    public function findAll(
        ?AppointmentStatus $status = null,
        ?TechnicianId $technicianId = null,
        ?VehicleId $vehicleId = null,
        ?\DateTimeImmutable $date = null,
    ): array {
        $query = AppointmentModel::query();

        if ($status !== null) {
            $query->where('status', $status->value);
        }

        if ($technicianId !== null) {
            $query->where('technician_id', $technicianId->value);
        }

        if ($vehicleId !== null) {
            $query->where('vehicle_id', $vehicleId->value);
        }

        if ($date !== null) {
            $query->whereDate('scheduled_at', $date->format('Y-m-d'));
        }

        return $query->orderBy('scheduled_at')
            ->get()
            ->map(fn ($m) => AppointmentMapper::toDomain($m))
            ->all();
    }
}
