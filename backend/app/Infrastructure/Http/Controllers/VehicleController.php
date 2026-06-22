<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Vehicle\CreateVehicle\CreateVehicleCommand;
use App\Application\Vehicle\CreateVehicle\CreateVehicleHandler;
use App\Application\Vehicle\GetVehicle\GetVehicleByIdHandler;
use App\Infrastructure\Http\Requests\CreateVehicleRequest;
use App\Infrastructure\Http\Resources\VehicleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class VehicleController extends Controller
{
    public function __construct(
        private readonly CreateVehicleHandler $createVehicle,
        private readonly GetVehicleByIdHandler $getVehicleById,
    ) {}

    public function show(string $id): VehicleResource
    {
        $dto = $this->getVehicleById->handle($id);

        return new VehicleResource((array) $dto);
    }

    public function store(CreateVehicleRequest $request): JsonResponse
    {
        $id = $this->createVehicle->handle(
            new CreateVehicleCommand(
                $request->validated('owner_id'),
                $request->validated('license_plate'),
                $request->validated('brand'),
                $request->validated('model'),
                (int) $request->validated('year'),
            ),
        );

        return response()->json(['id' => $id], 201);
    }
}
