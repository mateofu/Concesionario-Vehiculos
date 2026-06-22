<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\WorkStation\AssignTechnician\AssignTechnicianCommand;
use App\Application\WorkStation\AssignTechnician\AssignTechnicianHandler;
use App\Application\WorkStation\CreateWorkStation\CreateWorkStationCommand;
use App\Application\WorkStation\CreateWorkStation\CreateWorkStationHandler;
use App\Application\WorkStation\GetWorkStation\GetWorkStationByIdHandler;
use App\Application\WorkStation\GetWorkStation\GetWorkStationsHandler;
use App\Infrastructure\Http\Requests\AssignTechnicianRequest;
use App\Infrastructure\Http\Requests\CreateWorkStationRequest;
use App\Infrastructure\Http\Resources\WorkStationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorkStationController
{
    public function index(Request $request, GetWorkStationsHandler $handler): AnonymousResourceCollection
    {
        $workStations = array_map(
            fn ($dto) => (array) $dto,
            $handler->handle($request->query('location_id')),
        );

        return WorkStationResource::collection($workStations);
    }

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

        return new JsonResponse(['message' => 'Puesto de trabajo creado exitosamente.', 'id' => $id], 201);
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

        return new JsonResponse(['message' => 'Técnico asignado exitosamente.'], 200);
    }
}
