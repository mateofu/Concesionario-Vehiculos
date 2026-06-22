<?php

declare(strict_types=1);

namespace App\Domain\Location;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;

final class Location
{
    private function __construct(
        private readonly LocationId $id,
        private LocationName $name,
        private string $address,
    ) {}

    public static function create(
        LocationId $id,
        LocationName $name,
        string $address,
    ): self {
        return new self($id, $name, $address);
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
}
