<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Technician\Technician;
use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Technician\ValueObjects\TechnicianName;
use App\Domain\Technician\ValueObjects\TechnicianPhone;
use App\Domain\Technician\ValueObjects\TechnicianSpecialty;
use App\Infrastructure\Persistence\Eloquent\Models\TechnicianModel;

final class TechnicianMapper
{
    public static function toDomain(TechnicianModel $model): Technician
    {
        return Technician::create(
            new TechnicianId((int) $model->id),
            new TechnicianName($model->name),
            new TechnicianEmail($model->email),
            new TechnicianPhone($model->phone),
            new TechnicianSpecialty($model->specialty),
            (bool) $model->is_available,
        );
    }

    public static function toModel(Technician $technician): array
    {
        return [
            'name'         => $technician->name()->value,
            'email'        => $technician->email()->value,
            'phone'        => $technician->phone()->value,
            'specialty'    => $technician->specialty()->value,
            'is_available' => $technician->isAvailable(),
        ];
    }
}
