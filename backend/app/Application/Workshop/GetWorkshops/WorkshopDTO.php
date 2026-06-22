<?php

declare(strict_types=1);

namespace App\Application\Workshop\GetWorkshops;

final readonly class WorkshopDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $address,
    ) {}
}
