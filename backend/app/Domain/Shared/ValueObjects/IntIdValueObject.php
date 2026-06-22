<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

use InvalidArgumentException;

abstract class IntIdValueObject
{
    public function __construct(
        public readonly int $value,
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException(static::class . ' must be a non-negative integer.');
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
