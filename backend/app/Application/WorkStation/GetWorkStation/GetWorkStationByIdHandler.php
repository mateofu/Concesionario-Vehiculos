<?php

declare(strict_types=1);

namespace App\Application\WorkStation\GetWorkStation;

use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use RuntimeException;

final class GetWorkStationByIdHandler
{
    public function __construct(
        private readonly IWorkStationRepository $workStations,
    ) {}

    public function handle(string $id): WorkStationDTO
    {
        $workStation = $this->workStations->findById(new WorkStationId($id));

        if ($workStation === null) {
            throw new RuntimeException("WorkStation [{$id}] not found.");
        }

        return new WorkStationDTO(
            id: $workStation->id()->value,
            location_id: $workStation->locationId()->value,
            name: $workStation->name()->value,
        );
    }
}
