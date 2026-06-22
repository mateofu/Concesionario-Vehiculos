<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Owner\Owner;
use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Owner\ValueObjects\OwnerName;
use App\Domain\Owner\ValueObjects\OwnerPhone;
use App\Infrastructure\Persistence\Eloquent\Models\OwnerModel;

final class OwnerMapper
{
    public static function toDomain(OwnerModel $model): Owner
    {
        return Owner::create(
            new OwnerId($model->id),
            new OwnerName($model->name),
            new OwnerEmail($model->email),
            new OwnerPhone($model->phone),
        );
    }

    public static function toModel(Owner $owner): array
    {
        return [
            'id'    => $owner->id()->value,
            'name'  => $owner->name()->value,
            'email' => $owner->email()->value,
            'phone' => $owner->phone()->value,
        ];
    }
}
