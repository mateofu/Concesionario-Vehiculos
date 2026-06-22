<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Workshops ──────────────────────────────────────────────────────────
        $workshopId1 = (string) Str::uuid();
        $workshopId2 = (string) Str::uuid();

        DB::table('workshops')->insert([
            ['id' => $workshopId1, 'name' => 'Taller Norte', 'address' => 'Calle 100 #15-20', 'cost_center' => '001', 'created_at' => now(), 'updated_at' => now()],
            ['id' => $workshopId2, 'name' => 'Taller Sur',   'address' => 'Carrera 30 #45-10', 'cost_center' => '002', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Locations ──────────────────────────────────────────────────────────
        $locationId1 = (string) Str::uuid();
        $locationId2 = (string) Str::uuid();
        $locationId3 = (string) Str::uuid();

        DB::table('locations')->insert([
            ['id' => $locationId1, 'workshop_id' => $workshopId1, 'name' => 'Sede Principal', 'address' => 'Calle 100 #15-20', 'created_at' => now(), 'updated_at' => now()],
            ['id' => $locationId2, 'workshop_id' => $workshopId1, 'name' => 'Sede Secundaria', 'address' => 'Calle 110 #20-30', 'created_at' => now(), 'updated_at' => now()],
            ['id' => $locationId3, 'workshop_id' => $workshopId2, 'name' => 'Sede Única',     'address' => 'Carrera 30 #45-10', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Work Stations ──────────────────────────────────────────────────────
        $wsId1 = (string) Str::uuid();
        $wsId2 = (string) Str::uuid();
        $wsId3 = (string) Str::uuid();
        $wsId4 = (string) Str::uuid();

        DB::table('work_stations')->insert([
            ['id' => $wsId1, 'location_id' => $locationId1, 'name' => 'Puesto Motor 1',     'station_number' => 1, 'technical_area' => 'Motor',     'created_at' => now(), 'updated_at' => now()],
            ['id' => $wsId2, 'location_id' => $locationId1, 'name' => 'Puesto Eléctrico 1', 'station_number' => 2, 'technical_area' => 'Eléctrico', 'created_at' => now(), 'updated_at' => now()],
            ['id' => $wsId3, 'location_id' => $locationId2, 'name' => 'Puesto Frenos 1',    'station_number' => 1, 'technical_area' => 'Frenos',    'created_at' => now(), 'updated_at' => now()],
            ['id' => $wsId4, 'location_id' => $locationId3, 'name' => 'Puesto General 1',   'station_number' => 1, 'technical_area' => 'General',   'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Technicians ────────────────────────────────────────────────────────
        $techId1 = (string) Str::uuid();
        $techId2 = (string) Str::uuid();
        $techId3 = (string) Str::uuid();

        DB::table('technicians')->insert([
            ['id' => $techId1, 'name' => 'Carlos Pérez',  'email' => 'carlos@taller.co',  'phone' => '3001234567', 'specialty' => 'Motor',     'is_available' => true,  'created_at' => now(), 'updated_at' => now()],
            ['id' => $techId2, 'name' => 'Ana Gómez',     'email' => 'ana@taller.co',     'phone' => '3109876543', 'specialty' => 'Eléctrico', 'is_available' => true,  'created_at' => now(), 'updated_at' => now()],
            ['id' => $techId3, 'name' => 'Luis Martínez', 'email' => 'luis@taller.co',    'phone' => '3205551234', 'specialty' => 'Frenos',    'is_available' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Assign technicians to work stations ────────────────────────────────
        DB::table('work_station_technician')->insert([
            ['work_station_id' => $wsId1, 'technician_id' => $techId1, 'created_at' => now(), 'updated_at' => now()],
            ['work_station_id' => $wsId2, 'technician_id' => $techId2, 'created_at' => now(), 'updated_at' => now()],
            ['work_station_id' => $wsId3, 'technician_id' => $techId3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Owners ─────────────────────────────────────────────────────────────
        $ownerId1 = (string) Str::uuid();
        $ownerId2 = (string) Str::uuid();

        DB::table('owners')->insert([
            [
                'id'              => $ownerId1,
                'first_name'      => 'María',
                'last_name'       => 'Rodríguez',
                'document_type'   => 'CC',
                'document_number' => '12345678',
                'email'           => 'maria@email.com',
                'phone'           => '3111234567',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'id'              => $ownerId2,
                'first_name'      => 'Juan',
                'last_name'       => 'Torres',
                'document_type'   => 'CC',
                'document_number' => '87654321',
                'email'           => 'juan@email.com',
                'phone'           => '3229876543',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);

        // ── Vehicles ───────────────────────────────────────────────────────────
        $vehicleId1 = (string) Str::uuid();
        $vehicleId2 = (string) Str::uuid();

        DB::table('vehicles')->insert([
            ['id' => $vehicleId1, 'owner_id' => $ownerId1, 'license_plate' => 'ABC123', 'brand' => 'Toyota',  'model' => 'Corolla',   'year' => 2020, 'style' => 'Sedán',   'created_at' => now(), 'updated_at' => now()],
            ['id' => $vehicleId2, 'owner_id' => $ownerId2, 'license_plate' => 'XYZ789', 'brand' => 'Renault', 'model' => 'Duster',    'year' => 2022, 'style' => 'SUV',    'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Appointments ────────────────────────────────────────────────────────
        DB::table('appointments')->insert([
            [
                'id'               => (string) Str::uuid(),
                'vehicle_id'       => $vehicleId1,
                'technician_id'    => $techId1,
                'work_station_id'  => $wsId1,
                'scheduled_at'     => now()->addDays(1)->setTime(9, 0),
                'duration_minutes' => 60,
                'status'           => 'programada',
                'notes'            => 'Revisión de motor',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'id'               => (string) Str::uuid(),
                'vehicle_id'       => $vehicleId2,
                'technician_id'    => $techId2,
                'work_station_id'  => $wsId2,
                'scheduled_at'     => now()->addDays(2)->setTime(10, 0),
                'duration_minutes' => 90,
                'status'           => 'confirmada',
                'notes'            => 'Revisión sistema eléctrico',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }
}
