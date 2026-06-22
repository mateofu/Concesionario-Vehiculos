<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Mappers;

use App\Domain\Owner\Owner;
use App\Domain\Owner\ValueObjects\DocumentNumber;
use App\Domain\Owner\ValueObjects\DocumentType;
use App\Domain\Owner\ValueObjects\OwnerEmail;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Owner\ValueObjects\OwnerFirstName;
use App\Domain\Owner\ValueObjects\OwnerLastName;
use App\Domain\Owner\ValueObjects\OwnerPhone;
use App\Infrastructure\Persistence\Eloquent\Models\OwnerModel;

final class OwnerMapper
{
    public static function toDomain(OwnerModel $model): Owner
    {
        return Owner::create(
            new OwnerId((int) $model->id),
            new OwnerFirstName($model->first_name),
            new OwnerLastName($model->last_name),
            DocumentType::from($model->document_type),
            new DocumentNumber($model->document_number),
            new OwnerEmail($model->email),
            new OwnerPhone($model->phone),
        );
    }

    public static function toModel(Owner $owner): array
    {
        return [
            'first_name'      => $owner->firstName()->value,
            'last_name'       => $owner->lastName()->value,
            'document_type'   => $owner->documentType()->value,
            'document_number' => $owner->documentNumber()->value,
            'email'           => $owner->email()->value,
            'phone'           => $owner->phone()->value,
        ];
    }
}
