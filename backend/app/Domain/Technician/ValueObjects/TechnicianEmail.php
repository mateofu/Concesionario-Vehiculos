<?php

declare(strict_types=1);

namespace App\Domain\Technician\ValueObjects;

use App\Domain\Shared\ValueObjects\StringValueObject;
use InvalidArgumentException;

final class TechnicianEmail extends StringValueObject
{
    public function __construct(string $value)
    {
        $normalized = strtolower(trim($value));

        if (!filter_var($normalized, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address: {$value}");
        }

        parent::__construct($normalized);
    }
}
