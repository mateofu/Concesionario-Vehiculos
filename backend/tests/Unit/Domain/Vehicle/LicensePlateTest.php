<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Vehicle;

use App\Domain\Vehicle\ValueObjects\LicensePlate;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LicensePlateTest extends TestCase
{
    public function test_creates_and_normalizes_to_uppercase(): void
    {
        $plate = new LicensePlate('abc123');

        $this->assertSame('ABC123', $plate->value);
    }

    public function test_trims_whitespace_before_normalizing(): void
    {
        $plate = new LicensePlate('  xyz789  ');

        $this->assertSame('XYZ789', $plate->value);
    }

    public function test_accepts_already_uppercase_plate(): void
    {
        $plate = new LicensePlate('ABC123');

        $this->assertSame('ABC123', $plate->value);
    }

    public function test_rejects_empty_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new LicensePlate('');
    }

    public function test_rejects_whitespace_only_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new LicensePlate('   ');
    }
}
