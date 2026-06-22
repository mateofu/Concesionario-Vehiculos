<?php

declare(strict_types=1);

namespace App\Application\Workshop\GetWorkshops;

use App\Domain\Workshop\IWorkshopRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use RuntimeException;

final class GetWorkshopByIdHandler
{
    public function __construct(
        private readonly IWorkshopRepository $workshops,
    ) {}

    public function handle(string $id): WorkshopDTO
    {
        $workshop = $this->workshops->findById(new WorkshopId($id));

        if ($workshop === null) {
            throw new RuntimeException("Workshop [{$id}] not found.");
        }

        return new WorkshopDTO(
            id: $workshop->id()->value,
            name: $workshop->name()->value,
            address: $workshop->address(),
            cost_center: $workshop->costCenter()->value,
        );
    }
}
