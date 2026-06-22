<?php

declare(strict_types=1);

namespace App\Domain\Technician\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class TechnicianSpecialty extends StringValueObject
{
    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Technician specialty cannot be empty.');
        }

        parent::__construct($trimmed);
    }
}
