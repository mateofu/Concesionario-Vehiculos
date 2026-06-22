<?php

declare(strict_types=1);

namespace App\Application\WorkStation\GetWorkStation;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\WorkStation\IWorkStationRepository;

final class GetWorkStationsHandler
{
    public function __construct(
        private readonly IWorkStationRepository $workStations,
    ) {}

    /** @return WorkStationDTO[] */
    public function handle(?string $locationId = null): array
    {
        $workStations = $locationId !== null
            ? $this->workStations->findByLocation(new LocationId((int) $locationId))
            : $this->workStations->findAll();

        return array_map(
            fn ($ws) => new WorkStationDTO(
                id: $ws->id()->value,
                location_id: $ws->locationId()->value,
                name: $ws->name()->value,
                station_number: $ws->stationNumber(),
                technical_area: $ws->technicalArea()->value,
            ),
            $workStations,
        );
    }
}
