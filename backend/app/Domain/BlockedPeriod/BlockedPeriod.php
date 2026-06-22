<?php

declare(strict_types=1);

namespace App\Domain\BlockedPeriod;

use App\Domain\BlockedPeriod\ValueObjects\BlockedPeriodId;
use App\Domain\Location\ValueObjects\LocationId;
use InvalidArgumentException;

final class BlockedPeriod
{
    private function __construct(
        private readonly BlockedPeriodId $id,
        private readonly LocationId $locationId,
        private readonly \DateTimeImmutable $startsAt,
        private readonly \DateTimeImmutable $endsAt,
        private readonly ?string $reason,
    ) {}

    public static function create(
        BlockedPeriodId $id,
        LocationId $locationId,
        \DateTimeImmutable $startsAt,
        \DateTimeImmutable $endsAt,
        ?string $reason = null,
    ): self {
        if ($startsAt >= $endsAt) {
            throw new InvalidArgumentException(
                'starts_at must be before ends_at for a blocked period.'
            );
        }

        return new self($id, $locationId, $startsAt, $endsAt, $reason);
    }

    public function overlaps(\DateTimeImmutable $start, \DateTimeImmutable $end): bool
    {
        return $start < $this->endsAt && $end > $this->startsAt;
    }

    public function id(): BlockedPeriodId { return $this->id; }
    public function locationId(): LocationId { return $this->locationId; }
    public function startsAt(): \DateTimeImmutable { return $this->startsAt; }
    public function endsAt(): \DateTimeImmutable { return $this->endsAt; }
    public function reason(): ?string { return $this->reason; }
}
