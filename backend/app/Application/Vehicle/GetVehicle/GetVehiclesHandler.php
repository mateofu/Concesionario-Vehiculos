<?php

declare(strict_types=1);

namespace App\Application\Vehicle\GetVehicle;

use App\Application\Shared\PaginatedResult;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Vehicle\IVehicleRepository;

final class GetVehiclesHandler
{
    public function __construct(
        private readonly IVehicleRepository $vehicles,
    ) {}

    public function handle(?string $ownerId = null, int $page = 1, int $perPage = 15): PaginatedResult
    {
        if ($ownerId !== null) {
            $vehicles = $this->vehicles->findByOwner(new OwnerId((int) $ownerId));
            $total    = count($vehicles);
            $items    = array_slice($vehicles, ($page - 1) * $perPage, $perPage);
        } else {
            $items = $this->vehicles->findPaginated($page, $perPage);
            $total = $this->vehicles->countAll();
        }

        return new PaginatedResult(
            items: array_map(
                fn ($v) => new VehicleDTO(
                    id: $v->id()->value,
                    owner_id: $v->ownerId()->value,
                    license_plate: $v->licensePlate()->value,
                    brand: $v->brand(),
                    model: $v->model(),
                    year: $v->year()->value,
                    style: $v->style()->value,
                ),
                $items,
            ),
            total: $total,
            page: $page,
            perPage: $perPage,
        );
    }
}
