<?php

declare(strict_types=1);

namespace App\Domain\Owner;

use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;

interface IOwnerRepository
{
    public function save(Owner $owner): void;

    public function findById(OwnerId $id): ?Owner;

    public function findByEmail(OwnerEmail $email): ?Owner;

    /** @return Owner[] */
    public function findAll(): array;
}
