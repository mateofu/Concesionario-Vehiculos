<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\OperatingSchedule\GetSchedules\GetOperatingSchedulesHandler;
use App\Application\OperatingSchedule\SetSchedule\SetOperatingScheduleCommand;
use App\Application\OperatingSchedule\SetSchedule\SetOperatingScheduleHandler;
use App\Infrastructure\Http\Requests\SetOperatingScheduleRequest;
use App\Infrastructure\Http\Resources\OperatingScheduleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OperatingScheduleController
{
    public function index(string $locationId, GetOperatingSchedulesHandler $handler): AnonymousResourceCollection
    {
        $schedules = array_map(fn ($dto) => (array) $dto, $handler->handle($locationId));

        return OperatingScheduleResource::collection($schedules);
    }

    public function store(
        string $locationId,
        SetOperatingScheduleRequest $request,
        SetOperatingScheduleHandler $handler,
    ): JsonResponse {
        $id = $handler->handle(new SetOperatingScheduleCommand(
            locationId: $locationId,
            dayOfWeek:  $request->validated('day_of_week'),
            opensAt:    $request->validated('opens_at') ?? '00:00',
            closesAt:   $request->validated('closes_at') ?? '00:00',
            isClosed:   (bool) $request->validated('is_closed', false),
        ));

        return new JsonResponse(['message' => 'Horario guardado exitosamente.', 'id' => $id], 201);
    }
}
