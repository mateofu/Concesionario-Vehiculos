<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Workshop;

use App\Application\Workshop\CreateWorkshop\CreateWorkshopCommand;
use App\Application\Workshop\CreateWorkshop\CreateWorkshopHandler;
use App\Domain\Workshop\IWorkshopRepository;
use PHPUnit\Framework\TestCase;

class CreateWorkshopHandlerTest extends TestCase
{
    public function test_creates_workshop_and_returns_generated_id(): void
    {
        $repository = $this->createMock(IWorkshopRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->willReturn(1);

        $handler = new CreateWorkshopHandler($repository);
        $command  = new CreateWorkshopCommand('Taller Norte', 'Calle 100 #15-20', '001');

        $id = $handler->handle($command);

        $this->assertSame(1, $id);
    }

    public function test_delegates_persistence_to_repository(): void
    {
        $repository = $this->createMock(IWorkshopRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->willReturn(5);

        $handler = new CreateWorkshopHandler($repository);
        $command  = new CreateWorkshopCommand('Taller Sur', 'Carrera 30 #45-10', '002');

        $handler->handle($command);
    }
}
