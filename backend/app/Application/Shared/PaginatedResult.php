<?php

declare(strict_types=1);

namespace App\Application\Shared;

final readonly class PaginatedResult
{
    public int $lastPage;

    public function __construct(
        public array $items,
        public int   $total,
        public int   $page,
        public int   $perPage,
    ) {
        $this->lastPage = $perPage > 0 ? (int) ceil($total / $perPage) : 1;
    }

    public function meta(): array
    {
        return [
            'total'        => $this->total,
            'per_page'     => $this->perPage,
            'current_page' => $this->page,
            'last_page'    => $this->lastPage,
        ];
    }
}
