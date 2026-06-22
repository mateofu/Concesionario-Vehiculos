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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorkshopController
{
    public function index(GetWorkshopsHandler $handler): AnonymousResourceCollection
    {
        $workshops = array_map(fn ($dto) => (array) $dto, $handler->handle());

        return WorkshopResource::collection($workshops);
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
