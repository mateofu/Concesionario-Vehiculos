<?php

declare(strict_types=1);

namespace App\Application\Workshop\CreateWorkshop;

use App\Domain\Workshop\IWorkshopRepository;
use App\Domain\Workshop\ValueObjects\WorkshopId;
use App\Domain\Workshop\ValueObjects\WorkshopName;
use App\Domain\Workshop\Workshop;
use Illuminate\Support\Str;

final class CreateWorkshopHandler
{
    public function __construct(
        private readonly IWorkshopRepository $workshops,
    ) {}

    public function handle(CreateWorkshopCommand $command): string
    {
        $id = new WorkshopId((string) Str::uuid());

        $workshop = Workshop::create(
            $id,
            new WorkshopName($command->name),
            $command->address,
        );

        $this->workshops->save($workshop);

        return $id->value;
    }
}
