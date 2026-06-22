<?php

declare(strict_types=1);

namespace App\Domain\Technician;

use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Technician\ValueObjects\TechnicianName;
use App\Domain\Technician\ValueObjects\TechnicianPhone;
use App\Domain\Technician\ValueObjects\TechnicianSpecialty;

final class Technician
{
    private function __construct(
        private readonly TechnicianId $id,
        private TechnicianName $name,
        private TechnicianEmail $email,
        private TechnicianPhone $phone,
        private TechnicianSpecialty $specialty,
        private bool $isAvailable,
    ) {}

    public static function create(
        TechnicianId $id,
        TechnicianName $name,
        TechnicianEmail $email,
        TechnicianPhone $phone,
        TechnicianSpecialty $specialty,
        bool $isAvailable = true,
    ): self {
        return new self($id, $name, $email, $phone, $specialty, $isAvailable);
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

    public function specialty(): TechnicianSpecialty
    {
        return $this->specialty;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function markUnavailable(): void
    {
        $this->isAvailable = false;
    }

    public function markAvailable(): void
    {
        $this->isAvailable = true;
    }
}
