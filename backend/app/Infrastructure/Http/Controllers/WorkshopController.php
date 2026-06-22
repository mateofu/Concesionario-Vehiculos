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
use Illuminate\Routing\Controller;

class WorkshopController extends Controller
{
    public function __construct(
        private readonly GetWorkshopsHandler $getWorkshops,
        private readonly GetWorkshopByIdHandler $getWorkshopById,
        private readonly CreateWorkshopHandler $createWorkshop,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $workshops = $this->getWorkshops->handle();

        return WorkshopResource::collection(
            array_map(fn ($dto) => (array) $dto, $workshops),
        );
    }

    public function show(string $id): WorkshopResource
    {
        $dto = $this->getWorkshopById->handle($id);

        return new WorkshopResource((array) $dto);
    }

    public function store(CreateWorkshopRequest $request): JsonResponse
    {
        $id = $this->createWorkshop->handle(
            new CreateWorkshopCommand(
                $request->validated('name'),
                $request->validated('address'),
            ),
        );

        return response()->json(['id' => $id], 201);
    }
}
