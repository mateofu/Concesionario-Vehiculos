<?php

declare(strict_types=1);

namespace App\Domain\Owner;

use App\Domain\Owner\ValueObjects\DocumentNumber;
use App\Domain\Owner\ValueObjects\DocumentType;
use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Owner\ValueObjects\OwnerFirstName;
use App\Domain\Owner\ValueObjects\OwnerLastName;
use App\Domain\Owner\ValueObjects\OwnerPhone;

final class Owner
{
    private function __construct(
        private readonly OwnerId $id,
        private OwnerFirstName $firstName,
        private OwnerLastName $lastName,
        private DocumentType $documentType,
        private DocumentNumber $documentNumber,
        private OwnerEmail $email,
        private OwnerPhone $phone,
    ) {}

    public static function create(
        OwnerId $id,
        OwnerFirstName $firstName,
        OwnerLastName $lastName,
        DocumentType $documentType,
        DocumentNumber $documentNumber,
        OwnerEmail $email,
        OwnerPhone $phone,
    ): self {
        return new self($id, $firstName, $lastName, $documentType, $documentNumber, $email, $phone);
    }

    public function id(): OwnerId
    {
        return $this->id;
    }

    public function firstName(): OwnerFirstName
    {
        return $this->firstName;
    }

    public function lastName(): OwnerLastName
    {
        return $this->lastName;
    }

    public function fullName(): string
    {
        return "{$this->firstName->value} {$this->lastName->value}";
    }

    public function documentType(): DocumentType
    {
        return $this->documentType;
    }

    public function documentNumber(): DocumentNumber
    {
        return $this->documentNumber;
    }

    public function email(): OwnerEmail
    {
        return $this->email;
    }

    public function phone(): OwnerPhone
    {
        return $this->phone;
    }
}
