<?php

declare(strict_types=1);

namespace App\Application\Owner\GetOwner;

final readonly class OwnerDTO
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $document_type,
        public string $document_number,
        public string $email,
        public string $phone,
    ) {}
}
