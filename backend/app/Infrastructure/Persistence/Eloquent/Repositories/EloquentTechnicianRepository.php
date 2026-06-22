<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\Technician;
use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Infrastructure\Persistence\Eloquent\Mappers\TechnicianMapper;
use App\Infrastructure\Persistence\Eloquent\Models\TechnicianModel;

final class EloquentTechnicianRepository implements ITechnicianRepository
{
    public function save(Technician $technician): void
    {
        TechnicianModel::updateOrCreate(
            ['id' => $technician->id()->value],
            TechnicianMapper::toModel($technician),
        );
    }

    public function findById(TechnicianId $id): ?Technician
    {
        $model = TechnicianModel::find($id->value);

        return $model ? TechnicianMapper::toDomain($model) : null;
    }

    public function findByEmail(TechnicianEmail $email): ?Technician
    {
        $model = TechnicianModel::where('email', $email->value)->first();

        return $model ? TechnicianMapper::toDomain($model) : null;
    }

    public function findAll(): array
    {
        return TechnicianModel::all()
            ->map(fn ($m) => TechnicianMapper::toDomain($m))
            ->all();
    }
}
