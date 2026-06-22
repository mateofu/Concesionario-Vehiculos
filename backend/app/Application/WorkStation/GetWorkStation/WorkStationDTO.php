<?php

declare(strict_types=1);

namespace App\Application\WorkStation\GetWorkStation;

final readonly class WorkStationDTO
{
    public function __construct(
        public int $id,
        public int $workshop_id,
        public string $name,
        public int $station_number,
        public string $technical_area,
    ) {}
}
