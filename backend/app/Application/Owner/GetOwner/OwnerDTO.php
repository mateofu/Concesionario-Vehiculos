<?php

declare(strict_types=1);

namespace App\Application\Owner\GetOwner;

final readonly class OwnerDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $phone,
    ) {}
}
