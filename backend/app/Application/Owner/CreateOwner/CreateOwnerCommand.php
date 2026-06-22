<?php

declare(strict_types=1);

namespace App\Application\Owner\CreateOwner;

final readonly class CreateOwnerCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
    ) {}
}
