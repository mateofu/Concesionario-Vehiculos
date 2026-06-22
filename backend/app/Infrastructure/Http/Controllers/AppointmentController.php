<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Appointment\CancelAppointment\CancelAppointmentCommand;
use App\Application\Appointment\CancelAppointment\CancelAppointmentHandler;
use App\Application\Appointment\CreateAppointment\CreateAppointmentCommand;
use App\Application\Appointment\CreateAppointment\CreateAppointmentHandler;
use App\Application\Appointment\GetAppointments\GetAppointmentsHandler;
use App\Application\Appointment\UpdateAppointmentStatus\UpdateAppointmentStatusCommand;
use App\Application\Appointment\UpdateAppointmentStatus\UpdateAppointmentStatusHandler;
use App\Infrastructure\Http\Requests\CreateAppointmentRequest;
use App\Infrastructure\Http\Requests\UpdateAppointmentStatusRequest;
use App\Infrastructure\Http\Resources\AppointmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly GetAppointmentsHandler $getAppointments,
        private readonly CreateAppointmentHandler $createAppointment,
        private readonly UpdateAppointmentStatusHandler $updateStatus,
        private readonly CancelAppointmentHandler $cancelAppointment,
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $appointments = $this->getAppointments->handle(
            status: $request->query('status'),
            technicianId: $request->query('technician_id'),
            vehicleId: $request->query('vehicle_id'),
            date: $request->query('date'),
        );

        return AppointmentResource::collection(
            array_map(fn ($dto) => (array) $dto, $appointments),
        );
    }

    public function store(CreateAppointmentRequest $request): JsonResponse
    {
        $id = $this->createAppointment->handle(
            new CreateAppointmentCommand(
                $request->validated('vehicle_id'),
                $request->validated('technician_id'),
                $request->validated('work_station_id'),
                $request->validated('scheduled_at'),
                $request->validated('notes'),
            ),
        );

        return response()->json(['id' => $id], 201);
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, string $id): JsonResponse
    {
        $this->updateStatus->handle(
            new UpdateAppointmentStatusCommand($id, $request->validated('status')),
        );

        return response()->json(null, 204);
    }

    public function cancel(string $id): JsonResponse
    {
        $this->cancelAppointment->handle(
            new CancelAppointmentCommand($id),
        );

        return response()->json(null, 204);
    }
}
