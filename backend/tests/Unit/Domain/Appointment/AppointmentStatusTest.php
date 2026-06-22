<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Appointment;

use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use PHPUnit\Framework\TestCase;

class AppointmentStatusTest extends TestCase
{
    public function test_programada_can_transition_to_confirmada(): void
    {
        $this->assertTrue(
            AppointmentStatus::PROGRAMADA->canTransitionTo(AppointmentStatus::CONFIRMADA)
        );
    }

    public function test_programada_can_transition_to_cancelada(): void
    {
        $this->assertTrue(
            AppointmentStatus::PROGRAMADA->canTransitionTo(AppointmentStatus::CANCELADA)
        );
    }

    public function test_programada_cannot_transition_to_atendida(): void
    {
        $this->assertFalse(
            AppointmentStatus::PROGRAMADA->canTransitionTo(AppointmentStatus::ATENDIDA)
        );
    }

    public function test_confirmada_can_transition_to_atendida(): void
    {
        $this->assertTrue(
            AppointmentStatus::CONFIRMADA->canTransitionTo(AppointmentStatus::ATENDIDA)
        );
    }

    public function test_confirmada_can_transition_to_cancelada(): void
    {
        $this->assertTrue(
            AppointmentStatus::CONFIRMADA->canTransitionTo(AppointmentStatus::CANCELADA)
        );
    }

    public function test_atendida_cannot_transition_to_any_status(): void
    {
        $this->assertFalse(AppointmentStatus::ATENDIDA->canTransitionTo(AppointmentStatus::PROGRAMADA));
        $this->assertFalse(AppointmentStatus::ATENDIDA->canTransitionTo(AppointmentStatus::CONFIRMADA));
        $this->assertFalse(AppointmentStatus::ATENDIDA->canTransitionTo(AppointmentStatus::CANCELADA));
    }

    public function test_cancelada_cannot_transition_to_any_status(): void
    {
        $this->assertFalse(AppointmentStatus::CANCELADA->canTransitionTo(AppointmentStatus::PROGRAMADA));
        $this->assertFalse(AppointmentStatus::CANCELADA->canTransitionTo(AppointmentStatus::CONFIRMADA));
        $this->assertFalse(AppointmentStatus::CANCELADA->canTransitionTo(AppointmentStatus::ATENDIDA));
    }
}
