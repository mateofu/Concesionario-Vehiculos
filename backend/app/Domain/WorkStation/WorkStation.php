<?php

declare(strict_types=1);

namespace App\Domain\WorkStation;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;

final class WorkStation
{
    private function __construct(
        private readonly WorkStationId $id,
        private WorkStationName $name,
        private readonly LocationId $locationId,
    ) {}

    public static function create(
        WorkStationId $id,
        WorkStationName $name,
        LocationId $locationId,
    ): self {
        return new self($id, $name, $locationId);
    }

    public function id(): WorkStationId
    {
        return $this->id;
    }

    public function name(): WorkStationName
    {
        return $this->name;
    }

    public function locationId(): LocationId
    {
        return $this->locationId;
    }
}
