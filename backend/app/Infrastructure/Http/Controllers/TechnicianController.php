<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Technician\CreateTechnician\CreateTechnicianCommand;
use App\Application\Technician\CreateTechnician\CreateTechnicianHandler;
use App\Application\Technician\GetTechnicians\GetTechnicianByIdHandler;
use App\Application\Technician\GetTechnicians\GetTechniciansHandler;
use App\Infrastructure\Http\Requests\CreateTechnicianRequest;
use App\Infrastructure\Http\Resources\TechnicianResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TechnicianController
{
    public function index(GetTechniciansHandler $handler): AnonymousResourceCollection
    {
        $technicians = array_map(fn ($dto) => (array) $dto, $handler->handle());

        return TechnicianResource::collection($technicians);
    }

    public function show(string $id, GetTechnicianByIdHandler $handler): TechnicianResource
    {
        return new TechnicianResource((array) $handler->handle($id));
    }

    public function store(CreateTechnicianRequest $request, CreateTechnicianHandler $handler): JsonResponse
    {
        $id = $handler->handle(new CreateTechnicianCommand(
            name:      $request->validated('name'),
            email:     $request->validated('email'),
            phone:     $request->validated('phone'),
            specialty: $request->validated('specialty'),
        ));

        return new JsonResponse(['message' => 'Técnico creado exitosamente.', 'id' => $id], 201);
    }
}
