<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Workshop\CreateWorkshop\CreateWorkshopCommand;
use App\Application\Workshop\CreateWorkshop\CreateWorkshopHandler;
use App\Application\Workshop\GetWorkshops\GetWorkshopByIdHandler;
use App\Application\Workshop\GetWorkshops\GetWorkshopsHandler;
use App\Infrastructure\Http\Requests\CreateWorkshopRequest;
use App\Infrastructure\Http\Resources\WorkshopResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkshopController
{
    public function index(Request $request, GetWorkshopsHandler $handler): JsonResponse
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

    public function show(string $id, GetWorkshopByIdHandler $handler): WorkshopResource
    {
        return new WorkshopResource((array) $handler->handle($id));
    }

    public function store(CreateWorkshopRequest $request, CreateWorkshopHandler $handler): JsonResponse
    {
        $id = $handler->handle(new CreateWorkshopCommand(
            name: $request->validated('name'),
            address: $request->validated('address'),
            costCenter: $request->validated('cost_center'),
        ));

        return new JsonResponse(['message' => 'Taller creado exitosamente.', 'id' => $id], 201);
    }
}
