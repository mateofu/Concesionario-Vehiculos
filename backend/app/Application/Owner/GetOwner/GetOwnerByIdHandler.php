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
            $owner->id()->value,
            $owner->name()->value,
            $owner->email()->value,
            $owner->phone()->value,
        );
    }
}
