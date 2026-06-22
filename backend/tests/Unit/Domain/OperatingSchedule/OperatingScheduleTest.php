<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\OperatingSchedule;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\OperatingSchedule;
use App\Domain\OperatingSchedule\ValueObjects\OperatingScheduleId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class OperatingScheduleTest extends TestCase
{
    private function makeSchedule(
        string $opensAt = '08:00',
        string $closesAt = '18:00',
        bool $isClosed = false,
        int $dayOfWeek = 1,
    ): OperatingSchedule {
        return OperatingSchedule::create(
            new OperatingScheduleId(0),
            new LocationId(1),
            $dayOfWeek,
            $opensAt,
            $closesAt,
            $isClosed,
        );
    }

    public function test_slot_fully_within_schedule_is_valid(): void
    {
        $schedule = $this->makeSchedule('08:00', '18:00');
        $start    = new \DateTimeImmutable('2026-07-06 09:00:00');

        $this->assertTrue($schedule->containsSlot($start, 60));
    }

    public function test_slot_starting_exactly_at_opening_time_is_valid(): void
    {
        $schedule = $this->makeSchedule('08:00', '18:00');
        $start    = new \DateTimeImmutable('2026-07-06 08:00:00');

        $this->assertTrue($schedule->containsSlot($start, 60));
    }

    public function test_slot_ending_exactly_at_closing_time_is_valid(): void
    {
        $schedule = $this->makeSchedule('08:00', '18:00');
        $start    = new \DateTimeImmutable('2026-07-06 17:00:00');

        $this->assertTrue($schedule->containsSlot($start, 60));
    }

    public function test_slot_starting_before_opening_time_is_invalid(): void
    {
        $schedule = $this->makeSchedule('08:00', '18:00');
        $start    = new \DateTimeImmutable('2026-07-06 07:30:00');

        $this->assertFalse($schedule->containsSlot($start, 60));
    }

    public function test_slot_ending_after_closing_time_is_invalid(): void
    {
        $schedule = $this->makeSchedule('08:00', '18:00');
        $start    = new \DateTimeImmutable('2026-07-06 17:30:00');

        $this->assertFalse($schedule->containsSlot($start, 60));
    }

    public function test_slot_on_closed_day_is_invalid(): void
    {
        $schedule = $this->makeSchedule('08:00', '18:00', isClosed: true);
        $start    = new \DateTimeImmutable('2026-07-06 10:00:00');

        $this->assertFalse($schedule->containsSlot($start, 60));
    }

    public function test_slot_at_night_outside_business_hours_is_invalid(): void
    {
        $schedule = $this->makeSchedule('08:00', '18:00');
        $start    = new \DateTimeImmutable('2026-07-06 23:00:00');

        $this->assertFalse($schedule->containsSlot($start, 60));
    }

    public function test_rejects_day_of_week_less_than_one(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeSchedule(dayOfWeek: 0);
    }

    public function test_rejects_day_of_week_greater_than_seven(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeSchedule(dayOfWeek: 8);
    }

    public function test_rejects_opens_at_after_or_equal_to_closes_at(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeSchedule('18:00', '08:00');
    }

    public function test_rejects_invalid_time_format(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeSchedule('8:00', '18:00');
    }

    public function test_closed_day_skips_time_validation(): void
    {
        $schedule = $this->makeSchedule(isClosed: true);

        $this->assertTrue($schedule->isClosed());
    }
}
