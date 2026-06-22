<?php

declare(strict_types=1);

namespace App\Domain\Technician;

use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Technician\ValueObjects\TechnicianName;
use App\Domain\Technician\ValueObjects\TechnicianPhone;

final class Technician
{
    private function __construct(
        private readonly TechnicianId $id,
        private TechnicianName $name,
        private TechnicianEmail $email,
        private TechnicianPhone $phone,
    ) {}

    public static function create(
        TechnicianId $id,
        TechnicianName $name,
        TechnicianEmail $email,
        TechnicianPhone $phone,
    ): self {
        return new self($id, $name, $email, $phone);
    }

    public function id(): TechnicianId
    {
        return $this->id;
    }

    public function name(): TechnicianName
    {
        return $this->name;
    }

    public function email(): TechnicianEmail
    {
        return $this->email;
    }

    public function phone(): TechnicianPhone
    {
        return $this->phone;
    }
}
