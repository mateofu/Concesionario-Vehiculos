<?php

declare(strict_types=1);

namespace App\Application\Location\GetLocations;

final readonly class LocationDTO
{
    public function __construct(
        public string $id,
        public string $workshopId,
        public string $name,
        public string $address,
    ) {}
}
