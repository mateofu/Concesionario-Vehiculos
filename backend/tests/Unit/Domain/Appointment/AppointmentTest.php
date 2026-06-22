<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Appointment;

use App\Domain\Appointment\Appointment;
use App\Domain\Appointment\ValueObjects\AppointmentId;
use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use DomainException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AppointmentTest extends TestCase
{
    private function makeAppointment(int $durationMinutes = 60): Appointment
    {
        return Appointment::create(
            new AppointmentId(0),
            new VehicleId(1),
            new TechnicianId(1),
            new WorkStationId(1),
            new \DateTimeImmutable('2026-07-10 09:00:00'),
            $durationMinutes,
            'Revisión general',
        );
    }

    public function test_creates_with_status_programada(): void
    {
        $appointment = $this->makeAppointment();

        $this->assertSame(AppointmentStatus::PROGRAMADA, $appointment->status());
    }

    public function test_creates_with_correct_data(): void
    {
        $appointment = $this->makeAppointment(90);

        $this->assertSame(90, $appointment->durationMinutes());
        $this->assertSame('Revisión general', $appointment->notes());
    }

    public function test_rejects_duration_less_than_one_minute(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeAppointment(0);
    }

    public function test_ends_at_is_calculated_correctly(): void
    {
        $appointment = $this->makeAppointment(60);

        $this->assertSame('10:00', $appointment->endsAt()->format('H:i'));
    }

    public function test_update_status_from_programada_to_confirmada(): void
    {
        $appointment = $this->makeAppointment();
        $appointment->updateStatus(AppointmentStatus::CONFIRMADA);

        $this->assertSame(AppointmentStatus::CONFIRMADA, $appointment->status());
    }

    public function test_invalid_status_transition_throws_domain_exception(): void
    {
        $this->expectException(DomainException::class);

        $appointment = $this->makeAppointment();
        $appointment->updateStatus(AppointmentStatus::ATENDIDA);
    }

    public function test_cancel_sets_status_to_cancelada(): void
    {
        $appointment = $this->makeAppointment();
        $appointment->cancel();

        $this->assertSame(AppointmentStatus::CANCELADA, $appointment->status());
    }

    public function test_cancel_after_atendida_throws_domain_exception(): void
    {
        $this->expectException(DomainException::class);

        $appointment = $this->makeAppointment();
        $appointment->updateStatus(AppointmentStatus::CONFIRMADA);
        $appointment->updateStatus(AppointmentStatus::ATENDIDA);
        $appointment->cancel();
    }

    public function test_pull_domain_events_clears_event_list(): void
    {
        $appointment = $this->makeAppointment();
        $appointment->updateStatus(AppointmentStatus::CONFIRMADA);

        $events = $appointment->pullDomainEvents();
        $this->assertNotEmpty($events);

        $eventsAfterPull = $appointment->pullDomainEvents();
        $this->assertEmpty($eventsAfterPull);
    }
}
