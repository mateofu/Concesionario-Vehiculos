<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Owner\CreateOwner\CreateOwnerCommand;
use App\Application\Owner\CreateOwner\CreateOwnerHandler;
use App\Application\Owner\GetOwner\GetOwnerByIdHandler;
use App\Application\Owner\GetOwner\GetOwnersHandler;
use App\Infrastructure\Http\Requests\CreateOwnerRequest;
use App\Infrastructure\Http\Resources\OwnerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OwnerController
{
    public function index(GetOwnersHandler $handler): AnonymousResourceCollection
    {
        $owners = array_map(fn ($dto) => (array) $dto, $handler->handle());

        return OwnerResource::collection($owners);
    }

    public function show(string $id, GetOwnerByIdHandler $handler): OwnerResource
    {
        return new OwnerResource((array) $handler->handle($id));
    }

    public function store(CreateOwnerRequest $request, CreateOwnerHandler $handler): JsonResponse
    {
        $id = $handler->handle(new CreateOwnerCommand(
            firstName:      $request->validated('first_name'),
            lastName:       $request->validated('last_name'),
            documentType:   $request->validated('document_type'),
            documentNumber: $request->validated('document_number'),
            email:          $request->validated('email'),
            phone:          $request->validated('phone'),
        ));

        return new JsonResponse(['message' => 'Propietario creado exitosamente.', 'id' => $id], 201);
    }
}
