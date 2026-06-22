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
use Illuminate\Http\Request;

class OwnerController
{
    public function index(Request $request, GetOwnersHandler $handler): JsonResponse
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
