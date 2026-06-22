<?php

declare(strict_types=1);

namespace App\Application\Owner\CreateOwner;

use App\Domain\Owner\IOwnerRepository;
use App\Domain\Owner\Owner;
use App\Domain\Owner\ValueObjects\DocumentNumber;
use App\Domain\Owner\ValueObjects\DocumentType;
use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Owner\ValueObjects\OwnerFirstName;
use App\Domain\Owner\ValueObjects\OwnerLastName;
use App\Domain\Owner\ValueObjects\OwnerPhone;
use RuntimeException;

final class CreateOwnerHandler
{
    public function __construct(
        private readonly IOwnerRepository $owners,
    ) {}

    public function handle(CreateOwnerCommand $command): int
    {
        $email        = new OwnerEmail($command->email);
        $documentType = DocumentType::from($command->documentType);
        $documentNum  = new DocumentNumber($command->documentNumber);

        if ($this->owners->findByEmail($email) !== null) {
            throw new RuntimeException("An owner with email [{$command->email}] already exists.");
        }

        if ($this->owners->findByDocument($documentType, $documentNum) !== null) {
            throw new RuntimeException(
                "An owner with document [{$command->documentType} {$command->documentNumber}] already exists."
            );
        }

        $owner = Owner::create(
            new OwnerId(0),
            new OwnerFirstName($command->firstName),
            new OwnerLastName($command->lastName),
            $documentType,
            $documentNum,
            $email,
            new OwnerPhone($command->phone),
        );

        return $this->owners->save($owner);
    }
}
