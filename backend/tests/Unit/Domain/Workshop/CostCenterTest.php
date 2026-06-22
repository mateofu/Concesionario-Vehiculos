<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Workshop;

use App\Domain\Workshop\ValueObjects\CostCenter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CostCenterTest extends TestCase
{
    public function test_creates_with_valid_three_digit_code(): void
    {
        $cc = new CostCenter('001');

        $this->assertSame('001', $cc->value);
    }

    public function test_accepts_all_zeros(): void
    {
        $cc = new CostCenter('000');

        $this->assertSame('000', $cc->value);
    }

    public function test_accepts_max_value(): void
    {
        $cc = new CostCenter('999');

        $this->assertSame('999', $cc->value);
    }

    public function test_rejects_fewer_than_three_digits(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CostCenter('01');
    }

    public function test_rejects_more_than_three_digits(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CostCenter('0001');
    }

    public function test_rejects_non_numeric_characters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CostCenter('0A1');
    }

    public function test_rejects_empty_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CostCenter('');
    }

    public function test_equals_returns_true_for_same_value(): void
    {
        $a = new CostCenter('010');
        $b = new CostCenter('010');

        $this->assertTrue($a->equals($b));
    }

    public function test_equals_returns_false_for_different_value(): void
    {
        $a = new CostCenter('010');
        $b = new CostCenter('020');

        $this->assertFalse($a->equals($b));
    }
}
