<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\WorkStation\AssignTechnician\AssignTechnicianCommand;
use App\Application\WorkStation\AssignTechnician\AssignTechnicianHandler;
use App\Application\WorkStation\CreateWorkStation\CreateWorkStationCommand;
use App\Application\WorkStation\CreateWorkStation\CreateWorkStationHandler;
use App\Infrastructure\Http\Requests\AssignTechnicianRequest;
use App\Infrastructure\Http\Requests\CreateWorkStationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class WorkStationController extends Controller
{
    public function __construct(
        private readonly CreateWorkStationHandler $createWorkStation,
        private readonly AssignTechnicianHandler $assignTechnician,
    ) {}

    public function store(CreateWorkStationRequest $request): JsonResponse
    {
        $id = $this->createWorkStation->handle(
            new CreateWorkStationCommand(
                $request->validated('location_id'),
                $request->validated('name'),
            ),
        );

        return response()->json(['id' => $id], 201);
    }

    public function assignTechnician(AssignTechnicianRequest $request, string $workStationId): JsonResponse
    {
        $this->assignTechnician->handle(
            new AssignTechnicianCommand(
                $workStationId,
                $request->validated('technician_id'),
            ),
        );

        return response()->json(null, 204);
    }
}
