<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

abstract class StringValueObject
{
    public function __construct(
        public readonly string $value,
    ) {}

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
