<?php

declare(strict_types=1);

namespace App\Domain\WorkStation;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\WorkStation\ValueObjects\TechnicalArea;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;
use InvalidArgumentException;

final class WorkStation
{
    private function __construct(
        private readonly WorkStationId $id,
        private WorkStationName $name,
        private readonly LocationId $locationId,
        private int $stationNumber,
        private TechnicalArea $technicalArea,
    ) {}

    public static function create(
        WorkStationId $id,
        WorkStationName $name,
        LocationId $locationId,
        int $stationNumber,
        TechnicalArea $technicalArea,
    ): self {
        if ($stationNumber < 1) {
            throw new InvalidArgumentException('Station number must be a positive integer.');
        }

        return new self($id, $name, $locationId, $stationNumber, $technicalArea);
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

    public function stationNumber(): int
    {
        return $this->stationNumber;
    }

    public function technicalArea(): TechnicalArea
    {
        return $this->technicalArea;
    }
}
