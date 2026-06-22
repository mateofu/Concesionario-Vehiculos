<?php

declare(strict_types=1);

namespace App\Application\Location\CreateLocation;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;
use App\Domain\Workshop\IWorkshopRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use Illuminate\Support\Str;
use RuntimeException;

final class CreateLocationHandler
{
    public function __construct(
        private readonly ILocationRepository $locations,
        private readonly IWorkshopRepository $workshops,
    ) {}

    public function handle(CreateLocationCommand $command): string
    {
        $workshopId = new WorkshopId($command->workshopId);

        if ($this->workshops->findById($workshopId) === null) {
            throw new RuntimeException("Workshop [{$command->workshopId}] not found.");
        }

        $id = new LocationId((string) Str::uuid());

        $location = Location::create(
            $id,
            new LocationName($command->name),
            $command->address,
            $workshopId,
        );

        $this->locations->save($location);

        return $id->value;
    }
}
