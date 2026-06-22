<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Technician\CreateTechnician\CreateTechnicianCommand;
use App\Application\Technician\CreateTechnician\CreateTechnicianHandler;
use App\Application\Technician\GetTechnicians\GetTechniciansHandler;
use App\Infrastructure\Http\Requests\CreateTechnicianRequest;
use App\Infrastructure\Http\Resources\TechnicianResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class TechnicianController extends Controller
{
    public function __construct(
        private readonly GetTechniciansHandler $getTechnicians,
        private readonly CreateTechnicianHandler $createTechnician,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $technicians = $this->getTechnicians->handle();

        return TechnicianResource::collection(
            array_map(fn ($dto) => (array) $dto, $technicians),
        );
    }

    public function store(CreateTechnicianRequest $request): JsonResponse
    {
        $id = $this->createTechnician->handle(
            new CreateTechnicianCommand(
                $request->validated('name'),
                $request->validated('email'),
                $request->validated('phone'),
            ),
        );

        return response()->json(['id' => $id], 201);
    }
}
