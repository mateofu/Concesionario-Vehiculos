<?php

declare(strict_types=1);

namespace App\Domain\Workshop\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class WorkshopName extends StringValueObject
{
    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Workshop name cannot be empty.');
        }

        parent::__construct($trimmed);
    }
}
