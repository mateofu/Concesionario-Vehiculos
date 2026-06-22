<?php

declare(strict_types=1);

namespace App\Application\WorkStation\GetWorkStation;

use App\Application\Shared\PaginatedResult;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\WorkStation\IWorkStationRepository;

final class GetWorkStationsHandler
{
    public function __construct(
        private readonly IWorkStationRepository $workStations,
    ) {}

    public function handle(?string $workshopId = null, int $page = 1, int $perPage = 15): PaginatedResult
    {
        if ($workshopId !== null) {
            $all   = $this->workStations->findByWorkshop(new WorkshopId((int) $workshopId));
            $total = count($all);
            $ws    = array_slice($all, ($page - 1) * $perPage, $perPage);
        } else {
            $ws    = $this->workStations->findPaginated($page, $perPage);
            $total = $this->workStations->countAll();
        }

        return new PaginatedResult(
            items: array_map(
                fn ($w) => new WorkStationDTO(
                    id: $w->id()->value,
                    workshop_id: $w->workshopId()->value,
                    name: $w->name()->value,
                    station_number: $w->stationNumber(),
                    technical_area: $w->technicalArea()->value,
                ),
                $ws,
            ),
            total: $total,
            page: $page,
            perPage: $perPage,
        );
    }
}
