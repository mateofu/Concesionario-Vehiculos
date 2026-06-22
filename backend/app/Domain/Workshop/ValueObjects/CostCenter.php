<?php

declare(strict_types=1);

namespace App\Domain\Workshop\ValueObjects;

use InvalidArgumentException;

final class CostCenter
{
    public readonly string $value;

    public function __construct(string $value)
    {
        if (!preg_match('/^\d{3}$/', $value)) {
            throw new InvalidArgumentException(
                "Cost center must be exactly 3 numeric digits (e.g. 001, 010, 100). Got: [{$value}]"
            );
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
