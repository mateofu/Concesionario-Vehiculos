<?php

declare(strict_types=1);

namespace App\Application\Owner\GetOwner;

use App\Application\Shared\PaginatedResult;
use App\Domain\Owner\IOwnerRepository;

final class GetOwnersHandler
{
    public function __construct(
        private readonly IOwnerRepository $owners,
    ) {}

    public function handle(int $page = 1, int $perPage = 15): PaginatedResult
    {
        $items = array_map(
            fn ($o) => new OwnerDTO(
                id: $o->id()->value,
                first_name: $o->firstName()->value,
                last_name: $o->lastName()->value,
                document_type: $o->documentType()->value,
                document_number: $o->documentNumber()->value,
                email: $o->email()->value,
                phone: $o->phone()->value,
            ),
            $this->owners->findPaginated($page, $perPage),
        );

        return new PaginatedResult(
            items: $items,
            total: $this->owners->countAll(),
            page: $page,
            perPage: $perPage,
        );
    }
}
