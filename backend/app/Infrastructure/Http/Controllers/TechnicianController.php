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
use Illuminate\Http\Request;

class TechnicianController
{
    public function index(Request $request, GetTechniciansHandler $handler): JsonResponse
    {
        $result = $handler->handle(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('per_page', 15),
        );

        return new JsonResponse([
            'data' => $result->items,
            'meta' => $result->meta(),
        ]);
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
