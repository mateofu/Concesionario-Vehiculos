<?php

declare(strict_types=1);

namespace App\Domain\Owner;

use App\Domain\Owner\ValueObjects\DocumentNumber;
use App\Domain\Owner\ValueObjects\DocumentType;
use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;

interface IOwnerRepository
{
    public function save(Owner $owner): int;

    public function findById(OwnerId $id): ?Owner;

    public function findByEmail(OwnerEmail $email): ?Owner;

    public function findByDocument(DocumentType $type, DocumentNumber $number): ?Owner;

    /** @return Owner[] */
    public function findAll(): array;

    public function findPaginated(int $page, int $perPage): array;

    public function countAll(): int;
}
