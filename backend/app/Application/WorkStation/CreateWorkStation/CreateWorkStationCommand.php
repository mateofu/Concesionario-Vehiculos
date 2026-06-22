<?php

declare(strict_types=1);

namespace App\Application\WorkStation\CreateWorkStation;

final readonly class CreateWorkStationCommand
{
    public function __construct(
        public string $locationId,
        public string $name,
    ) {}
}
