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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VehicleController
{
    public function index(Request $request, GetVehiclesHandler $handler): AnonymousResourceCollection
    {
        $vehicles = array_map(
            fn ($dto) => (array) $dto,
            $handler->handle($request->query('owner_id')),
        );

        return VehicleResource::collection($vehicles);
    }

    public function show(string $id, GetVehicleByIdHandler $handler): VehicleResource
    {
        return new VehicleResource((array) $handler->handle($id));
    }

    public function store(CreateVehicleRequest $request, CreateVehicleHandler $handler): JsonResponse
    {
        $id = $handler->handle(new CreateVehicleCommand(
            ownerId:      $request->validated('owner_id'),
            licensePlate: $request->validated('license_plate'),
            brand:        $request->validated('brand'),
            model:        $request->validated('model'),
            year:         $request->validated('year'),
            style:        $request->validated('style'),
        ));

        return new JsonResponse(['message' => 'Vehículo creado exitosamente.', 'id' => $id], 201);
    }
}
