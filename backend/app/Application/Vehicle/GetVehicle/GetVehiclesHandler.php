<?php

declare(strict_types=1);

namespace App\Application\Vehicle\GetVehicle;

use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\IVehicleRepository;

final class GetVehiclesHandler
{
    public function __construct(
        private readonly IVehicleRepository $vehicles,
    ) {}

    /** @return VehicleDTO[] */
    public function handle(?string $ownerId = null): array
    {
        $vehicles = $ownerId !== null
            ? $this->vehicles->findByOwner(new OwnerId((int) $ownerId))
            : $this->vehicles->findAll();

        return array_map(
            fn ($v) => new VehicleDTO(
                id: $v->id()->value,
                owner_id: $v->ownerId()->value,
                license_plate: $v->licensePlate()->value,
                brand: $v->brand(),
                model: $v->model(),
                year: $v->year()->value,
                style: $v->style()->value,
            ),
            $vehicles,
        );
    }
}
