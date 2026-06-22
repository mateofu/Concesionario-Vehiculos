<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Vehicle\CreateVehicle\CreateVehicleCommand;
use App\Application\Vehicle\CreateVehicle\CreateVehicleHandler;
use App\Application\Vehicle\GetVehicle\GetVehicleByIdHandler;
use App\Application\Vehicle\GetVehicle\GetVehiclesHandler;
use App\Infrastructure\Http\Requests\CreateVehicleRequest;
use App\Infrastructure\Http\Resources\VehicleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController
{
    public function index(Request $request, GetVehiclesHandler $handler): JsonResponse
    {
        $result = $handler->handle(
            ownerId: $request->query('owner_id'),
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('per_page', 15),
        );

        return new JsonResponse([
            'data' => $result->items,
            'meta' => $result->meta(),
        ]);
    }

    public function show(string $id, GetVehicleByIdHandler $handler): VehicleResource
    {
        return new VehicleResource((array) $handler->handle($id));
    }

    public function store(CreateVehicleRequest $request, CreateVehicleHandler $handler): JsonResponse
    {
        $id = $handler->handle(new CreateVehicleCommand(
            ownerId:      (string) $request->validated('owner_id'),
            licensePlate: $request->validated('license_plate'),
            brand:        $request->validated('brand'),
            model:        $request->validated('model'),
            year:         $request->validated('year'),
            style:        $request->validated('style'),
        ));

        return new JsonResponse(['message' => 'Vehículo creado exitosamente.', 'id' => $id], 201);
    }
}
