<?php

declare(strict_types=1);

namespace App\Application\Location\CreateLocation;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;

final class CreateLocationHandler
{
    public function __construct(
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(CreateLocationCommand $command): int
    {
        $location = Location::create(
            new LocationId(0),
            new LocationName($command->name),
            $command->address,
        );

        return $this->locations->save($location);
    }
}
