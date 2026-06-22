<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Location\CreateLocation\CreateLocationCommand;
use App\Application\Location\CreateLocation\CreateLocationHandler;
use App\Application\Location\GetLocations\GetLocationByIdHandler;
use App\Application\Location\GetLocations\GetLocationsHandler;
use App\Infrastructure\Http\Requests\CreateLocationRequest;
use App\Infrastructure\Http\Resources\LocationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController
{
    public function __construct(
        private readonly GetLocationsHandler $getLocations,
        private readonly GetLocationByIdHandler $getLocationById,
        private readonly CreateLocationHandler $createLocation,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $result = $this->getLocations->handle(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('per_page', 15),
        );

        return new JsonResponse([
            'data' => $result->items,
            'meta' => $result->meta(),
        ]);
    }

    public function show(string $id): LocationResource
    {
        return new LocationResource((array) $this->getLocationById->handle($id));
    }

    public function store(CreateLocationRequest $request): JsonResponse
    {
        $id = $this->createLocation->handle(
            new CreateLocationCommand(
                $request->validated('name'),
                $request->validated('address'),
            ),
        );

        return response()->json(['message' => 'Sede creada exitosamente.', 'id' => $id], 201);
    }
}
