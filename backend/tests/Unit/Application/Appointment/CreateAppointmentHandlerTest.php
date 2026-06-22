<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Appointment;

use App\Application\Appointment\CreateAppointment\CreateAppointmentCommand;
use App\Application\Appointment\CreateAppointment\CreateAppointmentHandler;
use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\BlockedPeriod\IBlockedPeriodRepository;
use App\Domain\Location\ValueObjects\LocationId;
use App\Domain\OperatingSchedule\IOperatingScheduleRepository;
use App\Domain\OperatingSchedule\OperatingSchedule;
use App\Domain\OperatingSchedule\ValueObjects\OperatingScheduleId;
use App\Domain\Owner\ValueObjects\OwnerId;
use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Technician\Technician;
use App\Domain\Technician\ValueObjects\TechnicianEmail;
use App\Domain\Technician\ValueObjects\TechnicianId;
use App\Domain\Technician\ValueObjects\TechnicianName;
use App\Domain\Technician\ValueObjects\TechnicianPhone;
use App\Domain\Technician\ValueObjects\TechnicianSpecialty;
use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\Vehicle\Vehicle;
use App\Domain\Vehicle\ValueObjects\LicensePlate;
use App\Domain\Vehicle\ValueObjects\VehicleId;
use App\Domain\Vehicle\ValueObjects\VehicleStyle;
use App\Domain\Vehicle\ValueObjects\VehicleYear;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\WorkStation\ValueObjects\TechnicalArea;
use App\Domain\WorkStation\ValueObjects\WorkStationId;
use App\Domain\WorkStation\ValueObjects\WorkStationName;
use App\Domain\WorkStation\WorkStation;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CreateAppointmentHandlerTest extends TestCase
{
    private IAppointmentRepository $appointments;
    private IVehicleRepository $vehicles;
    private ITechnicianRepository $technicians;
    private IWorkStationRepository $workStations;
    private IOperatingScheduleRepository $operatingSchedules;
    private IBlockedPeriodRepository $blockedPeriods;

    protected function setUp(): void
    {
        $this->appointments       = $this->createMock(IAppointmentRepository::class);
        $this->vehicles           = $this->createMock(IVehicleRepository::class);
        $this->technicians        = $this->createMock(ITechnicianRepository::class);
        $this->workStations       = $this->createMock(IWorkStationRepository::class);
        $this->operatingSchedules = $this->createMock(IOperatingScheduleRepository::class);
        $this->blockedPeriods     = $this->createMock(IBlockedPeriodRepository::class);
    }

    private function makeHandler(): CreateAppointmentHandler
    {
        return new CreateAppointmentHandler(
            $this->appointments,
            $this->vehicles,
            $this->technicians,
            $this->workStations,
            $this->operatingSchedules,
            $this->blockedPeriods,
        );
    }

    private function makeVehicle(): Vehicle
    {
        return Vehicle::create(
            new VehicleId(1),
            new OwnerId(1),
            new LicensePlate('ABC123'),
            'Toyota',
            'Corolla',
            new VehicleYear(2020),
            new VehicleStyle('Sedán'),
        );
    }

    private function makeTechnician(): Technician
    {
        return Technician::create(
            new TechnicianId(1),
            new TechnicianName('Carlos Pérez'),
            new TechnicianEmail('carlos@taller.co'),
            new TechnicianPhone('3001234567'),
            new TechnicianSpecialty('Motor'),
        );
    }

    private function makeWorkStation(): WorkStation
    {
        return WorkStation::create(
            new WorkStationId(1),
            new WorkStationName('Puesto 1'),
            new LocationId(1),
            1,
            new TechnicalArea('Motor'),
        );
    }

    private function makeSchedule(string $opensAt = '08:00', string $closesAt = '18:00'): OperatingSchedule
    {
        return OperatingSchedule::create(
            new OperatingScheduleId(1),
            new LocationId(1),
            4,
            $opensAt,
            $closesAt,
        );
    }

    public function test_creates_appointment_successfully(): void
    {
        $this->vehicles->method('findById')->willReturn($this->makeVehicle());
        $this->technicians->method('findById')->willReturn($this->makeTechnician());
        $this->workStations->method('findById')->willReturn($this->makeWorkStation());
        $this->operatingSchedules->method('findByLocationAndDay')->willReturn($this->makeSchedule());
        $this->blockedPeriods->method('hasOverlap')->willReturn(false);
        $this->appointments->method('hasOverlap')->willReturn(false);
        $this->appointments->method('save')->willReturn(1);

        $handler = $this->makeHandler();
        $command  = new CreateAppointmentCommand('1', '1', '1', '2026-07-10 09:00:00', 60);

        $id = $handler->handle($command);

        $this->assertSame(1, $id);
    }

    public function test_throws_when_vehicle_not_found(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/Vehicle/');

        $this->vehicles->method('findById')->willReturn(null);

        $this->makeHandler()->handle(
            new CreateAppointmentCommand('99', '1', '1', '2026-07-10 09:00:00', 60)
        );
    }

    public function test_throws_when_technician_not_found(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/Technician/');

        $this->vehicles->method('findById')->willReturn($this->makeVehicle());
        $this->technicians->method('findById')->willReturn(null);

        $this->makeHandler()->handle(
            new CreateAppointmentCommand('1', '99', '1', '2026-07-10 09:00:00', 60)
        );
    }

    public function test_throws_when_work_station_not_found(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/WorkStation/');

        $this->vehicles->method('findById')->willReturn($this->makeVehicle());
        $this->technicians->method('findById')->willReturn($this->makeTechnician());
        $this->workStations->method('findById')->willReturn(null);

        $this->makeHandler()->handle(
            new CreateAppointmentCommand('1', '1', '99', '2026-07-10 09:00:00', 60)
        );
    }

    public function test_throws_when_no_schedule_configured_for_day(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/operating schedule/');

        $this->vehicles->method('findById')->willReturn($this->makeVehicle());
        $this->technicians->method('findById')->willReturn($this->makeTechnician());
        $this->workStations->method('findById')->willReturn($this->makeWorkStation());
        $this->operatingSchedules->method('findByLocationAndDay')->willReturn(null);

        $this->makeHandler()->handle(
            new CreateAppointmentCommand('1', '1', '1', '2026-07-10 09:00:00', 60)
        );
    }

    public function test_throws_when_appointment_falls_outside_operating_hours(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/operating hours/');

        $this->vehicles->method('findById')->willReturn($this->makeVehicle());
        $this->technicians->method('findById')->willReturn($this->makeTechnician());
        $this->workStations->method('findById')->willReturn($this->makeWorkStation());
        $this->operatingSchedules->method('findByLocationAndDay')->willReturn($this->makeSchedule('08:00', '18:00'));

        $this->makeHandler()->handle(
            new CreateAppointmentCommand('1', '1', '1', '2026-07-10 23:00:00', 60)
        );
    }

    public function test_throws_when_location_has_blocked_period(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/unavailable/');

        $this->vehicles->method('findById')->willReturn($this->makeVehicle());
        $this->technicians->method('findById')->willReturn($this->makeTechnician());
        $this->workStations->method('findById')->willReturn($this->makeWorkStation());
        $this->operatingSchedules->method('findByLocationAndDay')->willReturn($this->makeSchedule());
        $this->blockedPeriods->method('hasOverlap')->willReturn(true);

        $this->makeHandler()->handle(
            new CreateAppointmentCommand('1', '1', '1', '2026-07-10 09:00:00', 60)
        );
    }

    public function test_throws_when_work_station_has_overlapping_appointment(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/already has an appointment/');

        $this->vehicles->method('findById')->willReturn($this->makeVehicle());
        $this->technicians->method('findById')->willReturn($this->makeTechnician());
        $this->workStations->method('findById')->willReturn($this->makeWorkStation());
        $this->operatingSchedules->method('findByLocationAndDay')->willReturn($this->makeSchedule());
        $this->blockedPeriods->method('hasOverlap')->willReturn(false);
        $this->appointments->method('hasOverlap')->willReturn(true);

        $this->makeHandler()->handle(
            new CreateAppointmentCommand('1', '1', '1', '2026-07-10 09:00:00', 60)
        );
    }
}
