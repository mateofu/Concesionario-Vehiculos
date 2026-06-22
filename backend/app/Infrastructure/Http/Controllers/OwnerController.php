<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Owner\CreateOwner\CreateOwnerCommand;
use App\Application\Owner\CreateOwner\CreateOwnerHandler;
use App\Application\Owner\GetOwner\GetOwnerByIdHandler;
use App\Infrastructure\Http\Requests\CreateOwnerRequest;
use App\Infrastructure\Http\Resources\OwnerResource;
use Illuminate\Http\JsonResponse;

class OwnerController
{
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

        return new JsonResponse(['id' => $id], 201);
    }
}
