<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Workshop;

use App\Application\Workshop\CreateWorkshop\CreateWorkshopCommand;
use App\Application\Workshop\CreateWorkshop\CreateWorkshopHandler;
use App\Domain\Location\ILocationRepository;
use App\Domain\Location\Location;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\Location\ValueObjects\LocationName;
use App\Domain\Workshop\IWorkshopRepository;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CreateWorkshopHandlerTest extends TestCase
{
    private function makeLocation(): Location
    {
        return Location::create(
            new LocationId(1),
            new LocationName('Sede Principal'),
            'Calle 100 #15-20',
        );
    }

    public function test_creates_workshop_and_returns_generated_id(): void
    {
        $workshops = $this->createMock(IWorkshopRepository::class);
        $locations = $this->createMock(ILocationRepository::class);

        $locations->method('findById')->willReturn($this->makeLocation());
        $workshops->expects($this->once())->method('save')->willReturn(1);

        $handler = new CreateWorkshopHandler($workshops, $locations);
        $command = new CreateWorkshopCommand('1', 'Taller Norte', 'Calle 100 #15-20', '001');

        $id = $handler->handle($command);

        $this->assertSame(1, $id);
    }

    public function test_throws_when_location_not_found(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/Location/');

        $workshops = $this->createMock(IWorkshopRepository::class);
        $locations = $this->createMock(ILocationRepository::class);

        $locations->method('findById')->willReturn(null);

        $handler = new CreateWorkshopHandler($workshops, $locations);
        $handler->handle(new CreateWorkshopCommand('99', 'Taller Sur', 'Carrera 30 #45-10', '002'));
    }
}
