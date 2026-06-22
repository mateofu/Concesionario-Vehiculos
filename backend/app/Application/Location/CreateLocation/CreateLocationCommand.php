<?php

declare(strict_types=1);

namespace App\Application\Location\CreateLocation;

final readonly class CreateLocationCommand
{
    public function __construct(
        public string $name,
        public string $address,
    ) {}
}
