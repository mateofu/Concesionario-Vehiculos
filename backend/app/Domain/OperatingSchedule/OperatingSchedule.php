<?php

declare(strict_types=1);

namespace App\Domain\OperatingSchedule;

use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\ValueObjects\OperatingScheduleId;
use InvalidArgumentException;

final class OperatingSchedule
{
    private function __construct(
        private readonly OperatingScheduleId $id,
        private readonly LocationId $locationId,
        private readonly int $dayOfWeek,
        private string $opensAt,
        private string $closesAt,
        private bool $isClosed,
    ) {}

    public static function create(
        OperatingScheduleId $id,
        LocationId $locationId,
        int $dayOfWeek,
        string $opensAt,
        string $closesAt,
        bool $isClosed = false,
    ): self {
        self::guardDay($dayOfWeek);

        if (!$isClosed) {
            self::guardTime($opensAt, 'opens_at');
            self::guardTime($closesAt, 'closes_at');

            if ($opensAt >= $closesAt) {
                throw new InvalidArgumentException(
                    "opens_at [{$opensAt}] must be before closes_at [{$closesAt}]."
                );
            }
        }

        return new self($id, $locationId, $dayOfWeek, $opensAt, $closesAt, $isClosed);
    }

    public function containsSlot(\DateTimeImmutable $start, int $durationMinutes): bool
    {
        if ($this->isClosed) {
            return false;
        }

        $toMinutes = static function (string $hhmm): int {
            [$h, $m] = explode(':', $hhmm);
            return (int) $h * 60 + (int) $m;
        };

        $startMinutes = (int) $start->format('H') * 60 + (int) $start->format('i');
        $endMinutes   = $startMinutes + $durationMinutes;

        return $startMinutes >= $toMinutes($this->opensAt)
            && $endMinutes   <= $toMinutes($this->closesAt);
    }

    public function id(): OperatingScheduleId { return $this->id; }
    public function locationId(): LocationId { return $this->locationId; }
    public function dayOfWeek(): int { return $this->dayOfWeek; }
    public function opensAt(): string { return $this->opensAt; }
    public function closesAt(): string { return $this->closesAt; }
    public function isClosed(): bool { return $this->isClosed; }

    private static function guardDay(int $day): void
    {
        if ($day < 1 || $day > 7) {
            throw new InvalidArgumentException(
                "day_of_week must be between 1 (Monday) and 7 (Sunday). Got: [{$day}]"
            );
        }
    }

    private static function guardTime(string $time, string $field): void
    {
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $time)) {
            throw new InvalidArgumentException(
                "{$field} must be in HH:MM 24-hour format. Got: [{$time}]"
            );
        }
    }
}
