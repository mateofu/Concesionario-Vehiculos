<?php

declare(strict_types=1);

namespace App\Domain\WorkStation;

use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\WorkStation\ValueObjects\TechnicalArea;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;
use InvalidArgumentException;

final class WorkStation
{
    private function __construct(
        private readonly WorkStationId $id,
        private WorkStationName $name,
        private readonly WorkshopId $workshopId,
        private int $stationNumber,
        private TechnicalArea $technicalArea,
    ) {}

    public static function create(
        WorkStationId $id,
        WorkStationName $name,
        WorkshopId $workshopId,
        int $stationNumber,
        TechnicalArea $technicalArea,
    ): self {
        if ($stationNumber < 1) {
            throw new InvalidArgumentException('Station number must be a positive integer.');
        }

        return new self($id, $name, $workshopId, $stationNumber, $technicalArea);
    }

    public function id(): WorkStationId
    {
        return $this->id;
    }

    public function name(): WorkStationName
    {
        return $this->name;
    }

    public function workshopId(): WorkshopId
    {
        return $this->workshopId;
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
