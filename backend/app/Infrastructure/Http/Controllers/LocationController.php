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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class LocationController extends Controller
{
    public function __construct(
        private readonly GetLocationsHandler $getLocations,
        private readonly GetLocationByIdHandler $getLocationById,
        private readonly CreateLocationHandler $createLocation,
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $locations = $this->getLocations->handle(
            $request->query('workshop_id'),
        );

        return LocationResource::collection(
            array_map(fn ($dto) => (array) $dto, $locations),
        );
    }

    public function show(string $id): LocationResource
    {
        $dto = $this->getLocationById->handle($id);

        return new LocationResource((array) $dto);
    }

    public function store(CreateLocationRequest $request): JsonResponse
    {
        $id = $this->createLocation->handle(
            new CreateLocationCommand(
                $request->validated('workshop_id'),
                $request->validated('name'),
                $request->validated('address'),
            ),
        );

        return response()->json(['id' => $id], 201);
    }
}
