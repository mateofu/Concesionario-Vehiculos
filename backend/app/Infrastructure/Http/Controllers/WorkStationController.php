<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\WorkStation\AssignTechnician\AssignTechnicianCommand;
use App\Application\WorkStation\AssignTechnician\AssignTechnicianHandler;
use App\Application\WorkStation\CreateWorkStation\CreateWorkStationCommand;
use App\Application\WorkStation\CreateWorkStation\CreateWorkStationHandler;
use App\Application\WorkStation\GetWorkStation\GetWorkStationByIdHandler;
use App\Infrastructure\Http\Requests\AssignTechnicianRequest;
use App\Infrastructure\Http\Requests\CreateWorkStationRequest;
use App\Infrastructure\Http\Resources\WorkStationResource;
use Illuminate\Http\JsonResponse;

class WorkStationController
{
    public function show(string $id, GetWorkStationByIdHandler $handler): WorkStationResource
    {
        return new WorkStationResource((array) $handler->handle($id));
    }

    public function store(CreateWorkStationRequest $request, CreateWorkStationHandler $handler): JsonResponse
    {
        $id = $handler->handle(new CreateWorkStationCommand(
            locationId:    $request->validated('location_id'),
            name:          $request->validated('name'),
            stationNumber: $request->validated('station_number'),
            technicalArea: $request->validated('technical_area'),
        ));

        return new JsonResponse(['id' => $id], 201);
    }

    public function assignTechnician(
        string $id,
        AssignTechnicianRequest $request,
        AssignTechnicianHandler $handler,
    ): JsonResponse {
        $handler->handle(new AssignTechnicianCommand(
            workStationId: $id,
            technicianId:  $request->validated('technician_id'),
        ));

        return new JsonResponse(null, 204);
    }
}
