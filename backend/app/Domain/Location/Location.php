<?php

declare(strict_types=1);

namespace App\Domain\Location;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;
use App\Domain\Workshop\ValueObjects\WorkshopId;

final class Location
{
    private function __construct(
        private readonly LocationId $id,
        private LocationName $name,
        private string $address,
        private readonly WorkshopId $workshopId,
    ) {}

    public static function create(
        LocationId $id,
        LocationName $name,
        string $address,
        WorkshopId $workshopId,
    ): self {
        return new self($id, $name, $address, $workshopId);
    }

    public function id(): LocationId
    {
        return $this->id;
    }

    public function name(): LocationName
    {
        return $this->name;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function workshopId(): WorkshopId
    {
        return $this->workshopId;
    }
}
