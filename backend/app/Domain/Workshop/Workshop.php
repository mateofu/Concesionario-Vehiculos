<?php

declare(strict_types=1);

namespace App\Domain\Workshop;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Workshop\ValueObjects\CostCenter;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\Workshop\ValueObjects\WorkshopName;

final class Workshop
{
    private function __construct(
        private readonly WorkshopId $id,
        private readonly LocationId $locationId,
        private WorkshopName $name,
        private string $address,
        private CostCenter $costCenter,
    ) {}

    public static function create(
        WorkshopId $id,
        LocationId $locationId,
        WorkshopName $name,
        string $address,
        CostCenter $costCenter,
    ): self {
        return new self($id, $locationId, $name, $address, $costCenter);
    }

    public function id(): WorkshopId
    {
        return $this->id;
    }

    public function locationId(): LocationId
    {
        return $this->locationId;
    }

    public function name(): WorkshopName
    {
        return $this->name;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function costCenter(): CostCenter
    {
        return $this->costCenter;
    }
}
