<?php

declare(strict_types=1);

namespace App\Application\WorkStation\GetWorkStation;

final readonly class WorkStationDTO
{
    public function __construct(
        public string $id,
        public string $location_id,
        public string $name,
    ) {}
}
