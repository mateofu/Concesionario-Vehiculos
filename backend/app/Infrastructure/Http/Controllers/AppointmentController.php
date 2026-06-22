<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Appointment\CancelAppointment\CancelAppointmentHandler;
use App\Application\Appointment\CreateAppointment\CreateAppointmentCommand;
use App\Application\Appointment\CreateAppointment\CreateAppointmentHandler;
use App\Application\Appointment\GetAppointments\GetAppointmentByIdHandler;
use App\Application\Appointment\GetAppointments\GetAppointmentsHandler;
use App\Application\Appointment\UpdateAppointmentStatus\UpdateAppointmentStatusCommand;
use App\Application\Appointment\UpdateAppointmentStatus\UpdateAppointmentStatusHandler;
use App\Infrastructure\Http\Requests\CreateAppointmentRequest;
use App\Infrastructure\Http\Requests\UpdateAppointmentStatusRequest;
use App\Infrastructure\Http\Resources\AppointmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AppointmentController
{
    public function index(Request $request, GetAppointmentsHandler $handler): AnonymousResourceCollection
    {
        $appointments = array_map(
            fn ($dto) => (array) $dto,
            $handler->handle(
                status:      $request->query('status'),
                technicianId: $request->query('technician_id'),
                vehicleId:   $request->query('vehicle_id'),
                date:        $request->query('date'),
            ),
        );

        return AppointmentResource::collection($appointments);
    }

    public function show(string $id, GetAppointmentByIdHandler $handler): AppointmentResource
    {
        return new AppointmentResource((array) $handler->handle($id));
    }

    public function store(CreateAppointmentRequest $request, CreateAppointmentHandler $handler): JsonResponse
    {
        $id = $handler->handle(new CreateAppointmentCommand(
            vehicleId:       $request->validated('vehicle_id'),
            technicianId:    $request->validated('technician_id'),
            workStationId:   $request->validated('work_station_id'),
            scheduledAt:     $request->validated('scheduled_at'),
            durationMinutes: $request->validated('duration_minutes'),
            notes:           $request->validated('notes'),
        ));

        return new JsonResponse(['message' => 'Cita creada exitosamente.', 'id' => $id], 201);
    }

    public function updateStatus(
        string $id,
        UpdateAppointmentStatusRequest $request,
        UpdateAppointmentStatusHandler $handler,
    ): JsonResponse {
        $handler->handle(new UpdateAppointmentStatusCommand(
            appointmentId: $id,
            status:        $request->validated('status'),
        ));

        return new JsonResponse(['message' => 'Estado de la cita actualizado exitosamente.'], 200);
    }

    public function cancel(string $id, CancelAppointmentHandler $handler): JsonResponse
    {
        $handler->handle($id);

        return new JsonResponse(['message' => 'Cita cancelada exitosamente.'], 200);
    }
}
