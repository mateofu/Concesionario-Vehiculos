<?php

declare(strict_types=1);

namespace App\Domain\WorkStation\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class TechnicalArea extends StringValueObject
{
    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Technical area cannot be empty.');
        }

        parent::__construct($trimmed);
    }
}
