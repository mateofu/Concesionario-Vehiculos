<?php

declare(strict_types=1);

namespace App\Application\BlockedPeriod\CreateBlockedPeriod;

use App\Domain\BlockedPeriod\BlockedPeriod;
use App\Domain\BlockedPeriod\IBlockedPeriodRepository;
use App\Domain\BlockedPeriod\ValueObjects\BlockedPeriodId;
use App\Domain\Location\ILocationRepository;
use App\Domain\Location\ValueObjects\LocationId;
use RuntimeException;

final class CreateBlockedPeriodHandler
{
    public function __construct(
        private readonly IBlockedPeriodRepository $blockedPeriods,
        private readonly ILocationRepository $locations,
    ) {}

    public function handle(CreateBlockedPeriodCommand $command): int
    {
        $locationId = new LocationId((int) $command->locationId);

        if ($this->locations->findById($locationId) === null) {
            throw new RuntimeException("Location [{$command->locationId}] not found.");
        }

        $period = BlockedPeriod::create(
            new BlockedPeriodId(0),
            $locationId,
            new \DateTimeImmutable($command->startsAt),
            new \DateTimeImmutable($command->endsAt),
            $command->reason,
        );

        return $this->blockedPeriods->save($period);
    }
}
