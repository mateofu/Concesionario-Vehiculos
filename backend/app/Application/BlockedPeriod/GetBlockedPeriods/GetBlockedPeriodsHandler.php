<?php

declare(strict_types=1);

namespace App\Application\BlockedPeriod\GetBlockedPeriods;

use App\Domain\BlockedPeriod\IBlockedPeriodRepository;
use App\Domain\Location\ValueObjects\LocationId;

final class GetBlockedPeriodsHandler
{
    public function __construct(
        private readonly IBlockedPeriodRepository $blockedPeriods,
    ) {}

    /** @return BlockedPeriodDTO[] */
    public function handle(string $locationId): array
    {
        $periods = $this->blockedPeriods->findByLocation(new LocationId((int) $locationId));

        return array_map(
            fn ($p) => new BlockedPeriodDTO(
                id: $p->id()->value,
                location_id: $p->locationId()->value,
                starts_at: $p->startsAt()->format(\DateTimeInterface::ATOM),
                ends_at: $p->endsAt()->format(\DateTimeInterface::ATOM),
                reason: $p->reason(),
            ),
            $periods,
        );
    }
}
