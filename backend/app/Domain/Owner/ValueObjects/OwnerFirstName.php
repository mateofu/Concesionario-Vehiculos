<?php

declare(strict_types=1);

namespace App\Domain\Owner\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class OwnerFirstName extends StringValueObject
{
    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Owner first name cannot be empty.');
        }

        parent::__construct($trimmed);
    }
}
