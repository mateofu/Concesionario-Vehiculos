<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\BlockedPeriod\CreateBlockedPeriod\CreateBlockedPeriodCommand;
use App\Application\BlockedPeriod\CreateBlockedPeriod\CreateBlockedPeriodHandler;
use App\Application\BlockedPeriod\GetBlockedPeriods\GetBlockedPeriodsHandler;
use App\Infrastructure\Http\Requests\CreateBlockedPeriodRequest;
use App\Infrastructure\Http\Resources\BlockedPeriodResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlockedPeriodController
{
    public function index(string $locationId, GetBlockedPeriodsHandler $handler): AnonymousResourceCollection
    {
        $periods = array_map(fn ($dto) => (array) $dto, $handler->handle($locationId));

        return BlockedPeriodResource::collection($periods);
    }

    public function store(
        string $locationId,
        CreateBlockedPeriodRequest $request,
        CreateBlockedPeriodHandler $handler,
    ): JsonResponse {
        $id = $handler->handle(new CreateBlockedPeriodCommand(
            locationId: $locationId,
            startsAt:   $request->validated('starts_at'),
            endsAt:     $request->validated('ends_at'),
            reason:     $request->validated('reason'),
        ));

        return new JsonResponse(['message' => 'Periodo bloqueado creado exitosamente.', 'id' => $id], 201);
    }
}
