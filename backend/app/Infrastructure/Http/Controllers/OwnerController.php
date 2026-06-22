<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Owner\CreateOwner\CreateOwnerCommand;
use App\Application\Owner\CreateOwner\CreateOwnerHandler;
use App\Application\Owner\GetOwner\GetOwnerByIdHandler;
use App\Infrastructure\Http\Requests\CreateOwnerRequest;
use App\Infrastructure\Http\Resources\OwnerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class OwnerController extends Controller
{
    public function __construct(
        private readonly CreateOwnerHandler $createOwner,
        private readonly GetOwnerByIdHandler $getOwnerById,
    ) {}

    public function show(string $id): OwnerResource
    {
        $dto = $this->getOwnerById->handle($id);

        return new OwnerResource((array) $dto);
    }

    public function store(CreateOwnerRequest $request): JsonResponse
    {
        $id = $this->createOwner->handle(
            new CreateOwnerCommand(
                $request->validated('name'),
                $request->validated('email'),
                $request->validated('phone'),
            ),
        );

        return response()->json(['id' => $id], 201);
    }
}
