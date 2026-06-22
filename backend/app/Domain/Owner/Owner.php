<?php

declare(strict_types=1);

namespace App\Domain\Owner;

use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Owner\ValueObjects\OwnerName;
use App\Domain\Owner\ValueObjects\OwnerPhone;

final class Owner
{
    private function __construct(
        private readonly OwnerId $id,
        private OwnerName $name,
        private OwnerEmail $email,
        private OwnerPhone $phone,
    ) {}

    public static function create(
        OwnerId $id,
        OwnerName $name,
        OwnerEmail $email,
        OwnerPhone $phone,
    ): self {
        return new self($id, $name, $email, $phone);
    }

    public function id(): OwnerId
    {
        return $this->id;
    }

    public function name(): OwnerName
    {
        return $this->name;
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
