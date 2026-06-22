<?php

declare(strict_types=1);

namespace App\Application\Workshop\CreateWorkshop;

final readonly class CreateWorkshopCommand
{
    public function __construct(
        public string $name,
        public string $address,
        public string $costCenter,
    ) {}
}
