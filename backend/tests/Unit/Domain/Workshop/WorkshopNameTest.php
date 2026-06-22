<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Workshop;

use App\Domain\Workshop\ValueObjects\WorkshopName;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class WorkshopNameTest extends TestCase
{
    public function test_creates_with_valid_name(): void
    {
        $name = new WorkshopName('Taller Norte');

        $this->assertSame('Taller Norte', $name->value);
    }

    public function test_trims_surrounding_whitespace(): void
    {
        $name = new WorkshopName('  Taller Norte  ');

        $this->assertSame('Taller Norte', $name->value);
    }

    public function test_rejects_empty_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new WorkshopName('');
    }

    public function test_rejects_whitespace_only_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new WorkshopName('   ');
    }
}
