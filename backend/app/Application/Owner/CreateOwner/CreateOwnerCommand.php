<?php

declare(strict_types=1);

namespace App\Application\Owner\CreateOwner;

final readonly class CreateOwnerCommand
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $documentType,
        public string $documentNumber,
        public string $email,
        public string $phone,
    ) {}
}
