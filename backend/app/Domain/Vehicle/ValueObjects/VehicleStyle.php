<?php

declare(strict_types=1);

namespace App\Domain\Vehicle\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class VehicleStyle extends StringValueObject
{
    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Vehicle style cannot be empty.');
        }

        parent::__construct($trimmed);
    }
}
