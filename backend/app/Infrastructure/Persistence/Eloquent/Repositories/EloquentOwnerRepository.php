<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Owner\IOwnerRepository;
use App\Domain\Owner\Owner;
use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Infrastructure\Persistence\Eloquent\Mappers\OwnerMapper;
use App\Infrastructure\Persistence\Eloquent\Models\OwnerModel;

final class EloquentOwnerRepository implements IOwnerRepository
{
    public function save(Owner $owner): void
    {
        OwnerModel::updateOrCreate(
            ['id' => $owner->id()->value],
            OwnerMapper::toModel($owner),
        );
    }

    public function findById(OwnerId $id): ?Owner
    {
        $model = OwnerModel::find($id->value);

        return $model ? OwnerMapper::toDomain($model) : null;
    }

    public function findByEmail(OwnerEmail $email): ?Owner
    {
        $model = OwnerModel::where('email', $email->value)->first();

        return $model ? OwnerMapper::toDomain($model) : null;
    }

    public function findAll(): array
    {
        return OwnerModel::all()
            ->map(fn ($m) => OwnerMapper::toDomain($m))
            ->all();
    }
}
