<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Shared;

use App\Domain\Workshop\ValueObjects\WorkshopId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IntIdValueObjectTest extends TestCase
{
    public function test_creates_with_valid_positive_integer(): void
    {
        $id = new WorkshopId(5);

        $this->assertSame(5, $id->value);
    }

    public function test_creates_with_zero_as_placeholder(): void
    {
        $id = new WorkshopId(0);

        $this->assertSame(0, $id->value);
    }

    public function test_rejects_negative_value(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new WorkshopId(-1);
    }

    public function test_to_string_returns_value_as_string(): void
    {
        $id = new WorkshopId(42);

        $this->assertSame('42', (string) $id);
    }

    public function test_equals_returns_true_for_same_value(): void
    {
        $a = new WorkshopId(10);
        $b = new WorkshopId(10);

        $this->assertTrue($a->equals($b));
    }

    public function test_equals_returns_false_for_different_value(): void
    {
        $a = new WorkshopId(10);
        $b = new WorkshopId(20);

        $this->assertFalse($a->equals($b));
    }
}
