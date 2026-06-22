<?php

declare(strict_types=1);

namespace App\Domain\Vehicle\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class LicensePlate extends StringValueObject
{
    public function __construct(string $value)
    {
        $normalized = strtoupper(trim($value));

        if ($normalized === '') {
            throw new InvalidArgumentException('License plate cannot be empty.');
        }

        parent::__construct($normalized);
    }
}
