<?php

declare(strict_types=1);

namespace App\Domain\Vehicle\ValueObjects;

use InvalidArgumentException;

final class VehicleYear
{
    public function __construct(
        public readonly int $value,
    ) {
        $currentYear = (int) date('Y');

        if ($value < 1900 || $value > $currentYear + 1) {
            throw new InvalidArgumentException("Invalid vehicle year: {$value}");
        }
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
