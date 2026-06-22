<?php

declare(strict_types=1);

namespace App\Domain\Location\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class LocationName extends StringValueObject
{
    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Location name cannot be empty.');
        }

        parent::__construct($trimmed);
    }
}
