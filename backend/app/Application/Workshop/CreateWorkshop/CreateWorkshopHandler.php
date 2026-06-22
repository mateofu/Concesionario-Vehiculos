<?php

declare(strict_types=1);

namespace App\Application\Workshop\CreateWorkshop;

use App\Domain\Location\ILocationRepository;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Workshop\IWorkshopRepository;
use App\Domain\Workshop\ValueObjects\CostCenter;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\Workshop\ValueObjects\WorkshopName;
use App\Domain\Workshop\Workshop;
use RuntimeException;

final class CreateWorkshopHandler
{
    public function __construct(
        private readonly IWorkshopRepository $workshops,
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(CreateWorkshopCommand $command): int
    {
        $locationId = new LocationId((int) $command->locationId);

        if ($this->locations->findById($locationId) === null) {
            throw new RuntimeException("Location [{$command->locationId}] not found.");
        }

        $workshop = Workshop::create(
            new WorkshopId(0),
            $locationId,
            new WorkshopName($command->name),
            $command->address,
            new CostCenter($command->costCenter),
        );

        return $this->workshops->save($workshop);
    }
}
