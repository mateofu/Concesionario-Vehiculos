<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Appointment\Appointment;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Infrastructure\Persistence\Eloquent\Models\AppointmentModel;

final class AppointmentMapper
{
    public static function toDomain(AppointmentModel $model): Appointment
    {
        return Appointment::reconstitute(
            new AppointmentId($model->id),
            new VehicleId($model->vehicle_id),
            new TechnicianId($model->technician_id),
            new WorkStationId($model->work_station_id),
            new \DateTimeImmutable($model->scheduled_at),
            (int) $model->duration_minutes,
            AppointmentStatus::from($model->status),
            $model->notes,
        );
    }

    public static function toModel(Appointment $appointment): array
    {
        return [
            'id'               => $appointment->id()->value,
            'vehicle_id'       => $appointment->vehicleId()->value,
            'technician_id'    => $appointment->technicianId()->value,
            'work_station_id'  => $appointment->workStationId()->value,
            'scheduled_at'     => $appointment->scheduledAt()->format('Y-m-d H:i:s'),
            'duration_minutes' => $appointment->durationMinutes(),
            'status'           => $appointment->status()->value,
            'notes'            => $appointment->notes(),
        ];
    }
}
