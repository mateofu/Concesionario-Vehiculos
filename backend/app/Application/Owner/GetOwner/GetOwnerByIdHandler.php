<?php

declare(strict_types=1);

namespace App\Application\Owner\GetOwner;

use App\Domain\Owner\IOwnerRepository;
use App\Domain\Owner\ValueObjects\OwnerId;
use RuntimeException;

final class GetOwnerByIdHandler
{
    public function __construct(
        private readonly IOwnerRepository $owners,
    ) {}

    public function handle(string $id): OwnerDTO
    {
        $owner = $this->owners->findById(new OwnerId($id));

        if ($owner === null) {
            throw new RuntimeException("Owner [{$id}] not found.");
        }

        return new OwnerDTO(
            id: $owner->id()->value,
            first_name: $owner->firstName()->value,
            last_name: $owner->lastName()->value,
            document_type: $owner->documentType()->value,
            document_number: $owner->documentNumber()->value,
            email: $owner->email()->value,
            phone: $owner->phone()->value,
        );
    }
}
