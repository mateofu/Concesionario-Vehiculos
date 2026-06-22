<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Technician\Technician;
use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Technician\ValueObjects\TechnicianName;
use App\Domain\Technician\ValueObjects\TechnicianPhone;
use App\Infrastructure\Persistence\Eloquent\Models\TechnicianModel;

final class TechnicianMapper
{
    public static function toDomain(TechnicianModel $model): Technician
    {
        return Technician::create(
            new TechnicianId($model->id),
            new TechnicianName($model->name),
            new TechnicianEmail($model->email),
            new TechnicianPhone($model->phone),
        );
    }

    public static function toModel(Technician $technician): array
    {
        return [
            'id'    => $technician->id()->value,
            'name'  => $technician->name()->value,
            'email' => $technician->email()->value,
            'phone' => $technician->phone()->value,
        ];
    }
}
